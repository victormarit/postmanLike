<?php 

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class HomepageController extends AbstractController
{



    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        //$session = new Session();
        //$session->start();
//
        //$user = new User;
        //$user = $session->get('test');
//
        //dump($user->getId());
        return $this->render('pages/homepage.html.twig');
    }
}