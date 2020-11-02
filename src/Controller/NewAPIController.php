<?php 

namespace App\Controller;

use App\Entity\API;
use App\Form\APIType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class NewAPIController extends AbstractController
{

    /**
     * @Route("/newAPI", name="newRequest")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request):Response 
    {
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
            "form" => $form->createView()
        ]);
    }
}