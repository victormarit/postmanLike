<?php 

namespace App\Controller;

use App\Entity\API;
use App\Entity\User;
use App\Repository\UserRequestAPIRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserRequestController extends AbstractController
{

    

    public function __construct(UserRequestAPIRepository $userRepo, HttpClientInterface $client)
    {
        $this->userRepo = $userRepo;
        $this->client = $client;
    }

    public function resultAPI($url, $methode): array
    {

        $info = array();
        $response = $this->client->request(
            $methode,
            $url
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

    /**
     * @Route("/myRequests", name="userReq") //change le name sinon il a une erreur :)
     */
    public function index()
    {
        $session = new Session();

        if($session->get('isAuth'))
        {
            $user = new User;
            $user = $session->get('user');            
            $req = $this->userRepo->findUserAPI($user->getId());
            dump($req);

        }
        return $this->render('pages/userReq.html.twig', [
            'APIs' => $req
        ]);
    }


    /**
     * @Route("/?name={name}&url={id}", name="testAPI") 
     */
    public function testAPI($name, $id)
    {
        $api = $this->getDoctrine()->getRepository(API::class)->findOneBy(['id' => $id]);
        $info = $this->resultAPI($api->getUrl(), $api->getMethode());
        dump($api->getUrl());
        dump($info);
        return $this->render('pages/homepage.html.twig');
    }



}