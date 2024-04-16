<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/',name:"home")]
    public function renderHome(Request $request): Response {
        $session = $request->getSession();

        if($session->get("username")){
            $usrname = $session->get("username");
        } else {
            $usrname = "not logged in";
        }
        return $this->render("home.html.twig",["username"=>$usrname]);
    }

    public function renderNavBar(): Response{

        return $this->render("NavBar.html.twig");

    }

}
