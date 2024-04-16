<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    //generates a random username using letters and numbers
    function generateRandomUsername(): string{
        $usrname = "";
        $chars = ["a","b","c","d","e","f","g","h","i",""];
        $chars = "qwertzuiopasdfghjklyxcvbnmQWERTZUIOASDFGHJKLYXCVBNM1234567890!";
        $randomNum = rand(8,20);
        for ($i = 0;$i<$randomNum;$i++){

            $usrname .= $chars[rand(0,strlen($chars)-1)];
        }
        return $usrname;

    }
    //create new temporary user and set session variable to username
    #[Route('/new-temporary-user/')]
    function newTemporaryUser(Request $request): Response{
        $session = $request->getSession();
        $generatedUsername = $this->generateRandomUsername();
        $session->set("username",$generatedUsername);

        return $this->render("temporaryUser.html.twig",["generatedUsername"=>$generatedUsername]);
    }
    //clears user session (log out for temporary users)
    #[Route("/clear-user-session")]
    function clearUserSession(Request $request): Response {
        $session = $request->getSession();
        $username = $session->get("username");
        $session->clear();
        return new Response("<html><body>{$username} has been cleared <a href='/'>home</a></body></html>");
    }

}