<?php

namespace App\Controller;

use App\Entity\ThreadComment;
use App\Entity\Threads;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
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
        $error = false;
        $session = $request->getSession();
        $thread = new Threads();
        $form = $this->createFormBuilder($thread)
            ->add("name", TextType::class)
            ->add("description", TextareaType::class)
            ->add("create", SubmitType::class, ['label' => 'Create Thread'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $session->get("username")){
            $data = $form->getData();
            $entityManager->getRepository(Threads::class);
            $entityManager->persist($thread);
            $entityManager->flush();

            return $this->redirectToRoute("App\Controller\ThreadController::renderThread", array("id" => $thread->getId()));
        }
         if(!$session->get("username")){
             $error = true;
         }



        return $this->render("new-thread.html.twig", ["form" => $form,"error"=>$error]);
    }


    #[Route("/Threads/{id}")]
    function renderThread(int $id, EntityManagerInterface $entityManager,Request $request): Response
    {
        //check if session existst (if user is logged in)
        $userLoggedIn = $request->get("username");

        //get thread from db
        $thread = $entityManager->getRepository(Threads::class)->find($id);
        if (!$thread) {
            throw $this->createNotFoundException("No thread found with id: " . $id);
        }
        $threadTitle = $thread->getName();
        $threadDesc = $thread->getDescription();
        $threadCreated = $thread->getCreatedAt()->format("d-m-Y H:i:s");

        //new comment handling
        if($userLoggedIn) {
            $threadComment = new ThreadComment();
            $session = $request->getSession();

            $newCommentForm = $this->createFormBuilder($threadComment)
                ->add("text", TextType::class)
                ->add("Post", SubmitType::class, ["label" => "Post"])
                ->getForm();

            $threadComment->setByUsername($session->get("username"));
            $threadComment->setThreadId($id);
            $newCommentForm->handleRequest($request);

            if ($newCommentForm->isSubmitted() && $newCommentForm->isValid()) {
                $data = $newCommentForm->getData();

                $entityManager->getRepository(ThreadComment::class);
                $entityManager->persist($threadComment);
                $entityManager->flush();
            }
        }

        //rendering Comments:
        $rsm = new ResultSetMappingBuilder($entityManager);
        $rsm->addRootEntityFromClassMetadata("App\Entity\ThreadComment","t");
        $query = $entityManager->createNativeQuery("SELECT * FROM thread_comment t WHERE t.thread_id=".$id,$rsm);
        $data = $query->getArrayResult();


        return $this->render("thread.html.twig",["newComment"=>$newCommentForm ?? "","title"=>$threadTitle,"desc"=>$threadDesc,"created"=>$threadCreated,"threadComments"=>$data,"user_logged_in"=>$userLoggedIn]);
    }


   #function addComment(EntityManagerInterface $entityManager): Response{
    #    $threads = $entityManager->getRepository(threads::class);
   #     $threads->



  # }

}