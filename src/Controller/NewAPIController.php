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
use Symfony\Component\HttpClient\CurlHttpClient;


class NewAPIController extends AbstractController
{

    public function __construct(UserRequestAPIRepository $userRepo)
    {
        $this->userRepo = $userRepo;
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
                return $this->render('pages/newAPIRequest.html.twig', [
                    "form" => $form->createView(),
                    'code' => $info[0],
                    'type' => $info[1],
                    'json' => $info[2]
                ]);
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