<?php 

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRequestAPIRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class UserRequestController extends AbstractController
{

    public function __construct(UserRequestAPIRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @Route("/myRequests", name="homepage")
     */
    public function index()
    {
        $session = new Session();

        if($session->get('isAuth'))
        {
            $user = new User;
            $user = $session->get('user');
            $req = $this->userRepo->findByExampleField($user->getId());
            dump($req);
            return $this->render('pages/userReq.html.twig',[
                'requests' => $req
            ]);

        }
        return $this->render('pages/homepage.html.twig');
    }
}