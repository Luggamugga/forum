<?php

namespace App\Controller;

use App\Entity\Threads;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ThreadController extends AbstractController
{
    #[Route("/new-thread")]
    function newThread(): Response{
       return $this->render("new-thread.html.twig");
    }


    #[Route("/Threads/{id}")]
    function renderThread(int $id, EntityManagerInterface $entityManager): Response
    {
        $thread = $entityManager->getRepository(Threads::class)->find($id);

        if (!$thread) {
            throw $this->createNotFoundException("No thread found with id: " . $id);
        }

        return new Response("id: ".$id);


    }

}