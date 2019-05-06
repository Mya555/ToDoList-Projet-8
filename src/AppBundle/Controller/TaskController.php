<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Form\TaskType;
use AppBundle\Service\TaskManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\Exception\AccessException;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render( 'task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository( 'AppBundle:Task' )->findAll()] );
    }


    /**
     * @Route("/tasks/done", name="is_done_task")
     */
    public function IsDoneTask()
    {
        return $this->render( 'task/isDoneTask.html.twig', ['tasks' => $this->getDoctrine()->getRepository( 'AppBundle:Task' )->findAll()] );
    }


    /**
     * @Route("/tasks/create", name="task_create")
     * @param Request $request
     * @return RedirectResponse
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm( TaskType::class, $task );
        $form->handleRequest( $request );
        if ($this->getUser() == !null) {
            if ($form->isSubmitted() && $form->isValid()) {
                $this->get( 'app.task_manager' )->addTask( $task, $this->getUser() );
                return $this->redirectToRoute( 'task_list' );
            }
        } else {
            $this->addFlash( 'error', 'Connectez vous pour pouvoir créer une tâche.' );
            return $this->redirectToRoute( 'task_list' );
        }
        return $this->render( 'task/create.html.twig', ['form' => $form->createView()] );
    }


    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @param Task $task
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm( TaskType::class, $task );

        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get( 'app.task_manager' )->editTask();

            return $this->redirectToRoute( 'task_list' );
        }

        return $this->render( 'task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ] );
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * @param Task $task
     * @return RedirectResponse
     */
    public function toggleTaskAction(Task $task)
    {
        $taskManager = $this->get( 'app.task_manager' );
        $taskManager->toggleTask( $task );


        $this->addFlash( 'success', sprintf( 'La tâche %s a bien été marquée comme faite.', $task->getTitle() ) );

        return $this->redirectToRoute( 'task_list' );
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @param Task $task
     * @return RedirectResponse
     */
    public function deleteTaskAction(Task $task)
    {
        if ($this->getUser() === $task->getUser() || ($this->get( 'security.authorization_checker' )->isGranted( 'ROLE_ADMIN' ) && $task->getUser()->getUsername() === 'anonyme')) {

            $this->get( 'app.task_manager' )->deleteTask( $task );

            return $this->redirectToRoute( 'task_list' );

        } else {
            $this->addFlash( 'error', 'Vous n\'avez pas le droit d\'effectuer cette suppression' );
            return $this->redirectToRoute( 'task_list' );
        }

    }
}
