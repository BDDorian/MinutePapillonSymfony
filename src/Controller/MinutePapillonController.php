<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ListOfTasks;
use App\Entity\User;
use App\Form\UserType;
use App\Form\LoginType;
use App\Form\ListType;
use App\Entity\Task;
use App\Form\TaskType;
use App\Form\ChosenListType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class MinutePapillonController extends AbstractController
{
    /**
     * @Route("/minute/papillon", name="minute_papillon")
     */
    public function index()
    {
        return $this->render('minute_papillon/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('minute_papillon/home.html.twig');
    }


    /**
     * @Route("/createList", name="createlist")
     */
    public function createList(Request $request, ObjectManager $manager)
    {
        $list = new ListOfTasks();

        $form = $this->createForm(ListType::class, $list);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($list);
            $manager->flush();

            return $this->redirectToRoute('task');
        }

        return $this->render('minute_papillon/list.html.twig', [
            'formListCreation' =>$form->createView()
        ]);
    }

    /**
     * @Route("/choiceList", name="choiceList")
     */
    public function choiceList(ObjectManager $manager, Request $request)
    {
        $list= $this->getDoctrine()
                     ->getRepository(ListOfTasks::class)
                     ->findAll();
        $myList = new ListOfTasks();
        $form = $this->createForm(ChosenListType::class, $myList);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            
            $session = $request->getSession();
            $formData = $form->getData();
            $session->set('dataform',$formData);
            return $this->redirectToRoute('todolist');
        }
        
                     
        return $this->render('minute_papillon/choice.html.twig',[
            'listChosen' =>$list,
            'formChosenList' =>$form->createView()
        ]);
    }

    /**
     * @Route("/task", name="task")
     */
    public function task(ObjectManager $manager, Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        
        //Find the last list created
        $lastList = $this->getDoctrine()
                         ->getRepository(ListOfTasks::class)
                         ->findOneBy(array(), ['id' => 'desc'])
                         ->getId();
                         
        $form->handleRequest($request);               
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($task);
            $manager->flush();

            return $this->redirectToRoute('choiceList');
        }
        return $this->render('minute_papillon/task.html.twig', [
            'formCreateTask' => $form->createView(),
            'lastListId' => $lastList
        ]);
    }

    /**
     * @Route("/todolist", name="todolist")
     */
    public function todolist(Request $request)
    {
        $session =$request->getSession();
        $session->get('dataForm');
        $repo =$this->getDoctrine()->getRepository(ListOfTasks::class);
        $lists = $repo->findAll();

        $repoTask = $this->getDoctrine()->getRepository(Task::class);
        $myTask = $repoTask->findOneById(1);
        return $this->render('minute_papillon/todolist.html.twig', [
            'list' => $lists,
            'myData' =>$session,
            'myTask' =>$myTask
        ]);
    }

}
