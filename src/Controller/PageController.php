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
        $usrname = $session->get("username");
        return $this->render("home.html.twig",["username"=>$usrname]);
    }

}
