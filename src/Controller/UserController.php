<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    function generateRandomUsername(): string{
        $usrname = "";
        $chars = ["a","b","c","d","e","f","g","h","i",""];
        $chars = "qwertzuiopasdfghjklyxcvbnmQWERTZUIOASDFGHJKLYXCVBNM1234567890!$%&*";
        $randomNum = rand(8,20);
        for ($i = 0;$i<$randomNum;$i++){

            $usrname .= $chars[rand(0,strlen($chars)-1)];
        }
        return $usrname;

    }
    #[Route('/new-temporary-user/')]
    function newTemporaryUser(Request $request): Response{
        $session = $request->getSession();
        $generatedUsername = $this->generateRandomUsername();
        $session->set("username",$generatedUsername);

        return $this->render("temporaryUser.html.twig",["generatedUsername"=>$generatedUsername]);
    }

}