<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/',name:"home")]
    public function renderHome(): Response {
        return $this->render("home.html.twig");
    }
    #[Route('/{slug}',name: "nav")]
    public function page(string $slug): Response {
        if($slug=="home"){
            return new Response("<html><body>asdaf</body></html>");
        }
        if($slug=="asdf"){
            return new Response("a");
        }
        if($slug==""){
            return $this->render("home.html.twig");
        }
        return new Response("asdf");
    }

}
