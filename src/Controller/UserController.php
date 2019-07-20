<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
