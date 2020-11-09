<?php 

namespace App\Controller;

use App\Entity\API;
use App\Entity\User;
use App\Entity\UserRequestAPI;
use App\Form\APIType;
use App\Repository\UserRequestAPIRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class NewAPIController extends AbstractController
{

    private $client;

    public function __construct(HttpClientInterface $client, UserRequestAPIRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->client = $client;
    }

    public function traitementAPI($api): array
    {

        $info = array();
        $response = $this->client->request(
            $api->getMethode(),
            $api->getUrl()
        );

        $statusCode = $response->getStatusCode();
        array_push($info, $statusCode);
        $contentType = $response->getHeaders()['content-type'][0];
        array_push($info, $contentType);
        $content = $response->getContent();
        $content = $response->toArray();
        array_push($info, $content);
        return $info;
    }

    public function addUserRequestAPI($API_id, $UserID)
    {
        $this->userRepo->addUserAPI($API_id, $UserID);
    }

    /**
     * @Route("/newAPI", name="newRequest")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request):Response 
    {

        $session = $request->getSession();
        if($session->get('isAuth'))
        {
            $user = new User;
            $user = $session->get('user');            
            $userID = $user->getId();
        }
        $API = new API;
        $form =  $this->createForm(APIType::class, $API);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            if(isset($_POST['testeur']))
            {                
                $em = $this->getDoctrine()->getManager();
                $em->persist($API);
                $info = $this->traitementAPI($API);
                dump($info);
                return $this->render('pages/homepage.html.twig');
            }
            else{
                $em = $this->getDoctrine()->getManager();
                $em->persist($API);
                $em->flush();
                $this->addUserRequestAPI($API->getID(), $userID);
                dump($API->getID());
                return $this->redirectToRoute('userReq');
            }  
        }
        return $this->render('pages/newAPIRequest.html.twig', [
            "form" => $form->createView()
       ]);
    }



}