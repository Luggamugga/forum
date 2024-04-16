<?php

namespace App\Controller;

use App\Entity\ThreadComment;
use App\Entity\Threads;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[HasLifecycleCallbacks]
class ThreadController extends AbstractController
{


    #[Route("/new-thread")]
    function newThread(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thread = new Threads();
        $form = $this->createFormBuilder($thread)
            ->add("name", TextType::class)
            ->add("description", TextareaType::class)
            ->add("create", SubmitType::class, ['label' => 'Create Thread'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager->getRepository(Threads::class);
            $entityManager->persist($thread);
            $entityManager->flush();

            return $this->redirectToRoute("App\Controller\ThreadController::renderThread", array("id" => $thread->getId()));
        }

        return $this->render("new-thread.html.twig", ["form" => $form]);
    }


    #[Route("/Threads/{id}")]
    function renderThread(int $id, EntityManagerInterface $entityManager): Response
    {
        $thread = $entityManager->getRepository(Threads::class)->find($id);
        if (!$thread) {
            throw $this->createNotFoundException("No thread found with id: " . $id);
        }
        $threadTitle = $thread->getName();
        $threadDesc = $thread->getDescription();
        $threadCreated = $thread->getCreatedAt()->format("d-m-Y H:i:s");

        $threadComment = new ThreadComment();
        $newCommentForm = $this->createFormBuilder($threadComment);

        return $this->render("thread.html.twig",["title"=>$threadTitle,"desc"=>$threadDesc,"created"=>$threadCreated]);
    }

   # function addComment($text): Response{

    #}

}