<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{

    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $tasks_repo=$this->getDoctrine()->getRepository(Task::class);
        $tasks = $tasks_repo->findAll([],['id'=>'DESC']);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    public function detail(Task $task){
        if(!$task){
            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/detail.html.twig',[
           'task'=>$task
        ]);
    }

    public function creation(Request $request){

        return $this->render('task\creation.html.twig');
    }
}
