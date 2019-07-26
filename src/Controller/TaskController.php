<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserInterface;
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
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $task->setUser($this->getUser());
            $task->setCreateAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', ['id'=>$task->getId()])
            );

        }
        return $this->render('task\creation.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    public function myTasks(){
        $user =$this->getUser();
        $tasks = $user->getTasks();

        return $this->render('task/my-tasks.html.twig',[
           'tasks'=>$tasks
        ]);
    }

    public function edit(Request $request, Task $task){

        if( $this->getUser()->getId() != $task->getUser()->getId()){
           return $this->redirectToRoute('tasks');
        }

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('task_detail', ['id'=>$task->getId()])
            );

        }

        return $this->render('task/creation.html.twig',[
           'edit'=>true,
            'form'=>$form->createView()
        ]);
    }

    public function delete(Task $task){
        if(!$task){
            return $this->redirectToRoute('tasks');
        }

        if( $this->getUser()->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        return $this->redirectToRoute('my_tasks');
    }
}
