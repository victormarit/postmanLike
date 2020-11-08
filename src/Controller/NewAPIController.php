<?php 

namespace App\Controller;

use App\Entity\API;
use App\Form\APIType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Contracts\HttpClient\HttpClientInterface;


class NewAPIController extends AbstractController
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function traitementAPI(): array
    {

        $info = array();
        $response = $this->client->request(
            'GET',
            'https://cat-fact.herokuapp.com/facts/random?amount=2'
        );

        $statusCode = $response->getStatusCode();
        array_push($info, $statusCode);
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        array_push($info, $contentType);
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        array_push($info, $content);
        dump($info);
        return $info;
    }

    /**
     * @Route("/newAPI", name="newRequest")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request):Response 
    {
        $info = $this->traitementAPI();


        $API = new API;
        $form =  $this->createForm(APIType::class, $API);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($API);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('pages/newAPIRequest.html.twig', [
            "form" => $form->createView(),
            'code' => $info[0],
            'type' => $info[1],
            'contents' => $info[2]
        ]);
    }

}