<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Entity\User;

class TaskController extends AbstractController
{

    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $tasks_repo=$this->getDoctrine()->getRepository(Task::class);
        $tasks = $tasks_repo->findAll();

        foreach($tasks as $task){
            echo $task->getUser()->getEmail().':'.$task->getTitle()."<br>";
        }


        $user_repo = $this->getDoctrine()->getManager()->getRepository(User::class);
        $users = $user_repo->findAll();
        foreach($users as $user){
            echo '<h1>'.$user->getName().' '.$user->getSurname().'</h1>';
            foreach($user->getTasks() as $task){
                echo $task->getUser()->getEmail().':'.$task->getTitle()."<br>";
            }
        }

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
