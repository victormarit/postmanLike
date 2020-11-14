<?php 

namespace App\Controller;

use App\Entity\API;
use App\Entity\User;
use App\Form\APIType;
use App\Repository\UserRequestAPIRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\NewAPIController;
use Symfony\Component\HttpClient\CurlHttpClient;

class UserRequestController extends AbstractController
{
    public function __construct(UserRequestAPIRepository $userRepo, HttpClientInterface $client)
    {
        $this->userRepo = $userRepo;
        $this->client = $client;
    }

    public function traitementAPI($api)
    {
        $curl = new CurlHttpClient();
        $curl=curl_init($api->getUrl());

        switch ($api->getMethode()) {
            
            case 'GET':
                if($api->getHeaderTokken())
                {
                    $header=$api->getHeaderTokken();
                    $value = explode(",", $header);
        
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => $value
            
                    ]);
                }
                else
                {
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true
            
                    ]);  
                }
                break;

            case 'POST':
                if($api->getHeaderTokken())
                {
        
                    $header=$api->getHeaderTokken();
                    $value = explode(",", $header);
                    $valueBody=$api->getBody();
                    $body = explode(",", $valueBody);
        
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => $value,
                        CURLOPT_POSTFIELDS => $body
            
                    ]);
                }
                else
                {
                    $value=$api->getBody();
                    $body = explode(",", $value);
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS => $body
            
                    ]);
                }
                break;

            case 'DELETE':
                if($api->getHeaderTokken())
                {
        
                    $header=$api->getHeaderTokken();
                    $value = explode(",", $header);
                    $valueBody=$api->getBody();
                    $body = explode(",", $valueBody);
        
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => $value,
                        CURLOPT_POSTFIELDS => $body,
                        CURLOPT_CUSTOMREQUEST => "DELETE"
            
                    ]);
                }
                else
                {
                    $value=$api->getBody();
                    $body = explode(",", $value);
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS => $body,
                        CURLOPT_CUSTOMREQUEST => "DELETE"
            
                    ]);
                }
                break;

            case 'PUT':
                if($api->getHeaderTokken())
                {
            
                    $header=$api->getHeaderTokken();
                    $value = explode(",", $header);
                    $valueBody=$api->getBody();
                    $body = explode(",", $valueBody);
            
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => $value,
                        CURLOPT_POSTFIELDS => $body,
                        CURLOPT_CUSTOMREQUEST => "DELETE"
            
                    ]);
                }
                else
                {
                    $value=$api->getBody();
                    $body = explode(",", $value);
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS => $body,
                        CURLOPT_CUSTOMREQUEST => "PUT"
            
                    ]);
                }
                break;
            case 'UPDATE':
                if($api->getHeaderTokken())
                {
        
                    $header=$api->getHeaderTokken();
                    $value = explode(",", $header);
                    $valueBody=$api->getBody();
                    $body = explode(",", $valueBody);
        
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => $value,
                        CURLOPT_POSTFIELDS => $body,
                        CURLOPT_CUSTOMREQUEST => "DELETE"
            
                    ]);
                }
                else
                {
                    $value=$api->getBody();
                    $body = explode(",", $value);
                    curl_setopt_array($curl, [
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS => $body,
                        CURLOPT_CUSTOMREQUEST => "UPDATE"
            
                    ]);
                }
                break;
        } 


        $data = curl_exec($curl);
        
        if(!$data)
        {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);
            curl_close($curl);
            return [$statusCode, 'Aucun', $error];
        }
        else
        {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
            $data = json_decode($data);
            $data = json_encode($data, JSON_PRETTY_PRINT);
            curl_close($curl);
            return [$statusCode, $contentType , $data];
        
        }
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
        $info = $this->traitementAPI($api);
        

        return $this->render('pages/apiTesteur.html.twig', [
            'code' => $info[0],
            'type' => $info[1],
            'json' => $info[2]
        ]);


    }

    /**
     * @Route("/delAPI/?name={name}&url={id}", name="delAPI") 
     */
    public function delAPI($name, $id, Request $request)
    {
        $session = $request->getSession();
        
        $api = $this->getDoctrine()->getRepository(API::class)->findOneBy(['id' => $id]);
        $user = new User;
        $user = $session->get('user');   

        $this->userRepo->delUserAPi($api->getId(),$user->getId());
        $em = $this->getDoctrine()->getManager();
        $em->remove($api);
        $em->flush();
        return $this->redirectToRoute('userReq');
    }


    /**
     * @Route("/updateAPI/?name={name}&url={id}", name="updateAPI") 
     */
    public function updateAPI($name, $id, Request $request)
    {
        $api = $this->getDoctrine()->getRepository(API::class)->findOneBy(['id' => $id]);  
        $form =  $this->createForm(APIType::class, $api);
        $form->handleRequest($request, [
            "form" => $form->createView()
       ]);
       if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($api);
            $em->flush();
            return $this->redirectToRoute('userReq');
        } 

        return $this->render('pages/updateAPI.html.twig',[
            "form" => $form->createView()
       ]);
    }


}