<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 09/04/2019
 * Time: 14:32
 */

namespace AppBundle\Service;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class TaskManager
{
    private $entityManager;
    private $session;

    /**
     * TaskManager constructor.
     * @param EntityManager $manager
     * @param Session $session
     */
    public function __construct(EntityManager $manager, Session $session)
    {
        $this->session = $session;
        $this->entityManager = $manager;
    }

    private function addFlash($key, $message)
    {
        $this->session->getFlashBag( $key, $message );
    }

    public function toggleTask($task)
    {
        $task->toggle( !$task->isDone() );
        $this->entityManager->flush();
    }

    public function addTask(Task $task, User $user)
    {
        $task->setUser( $user );
        $this->entityManager->persist( $task );
        $this->entityManager->flush();
        $this->addFlash( 'success', 'La tâche a été bien été ajoutée.' );
    }

    public function editTask()
    {
        $this->entityManager->flush();
        $this->addFlash( 'success', 'La tâche a bien été modifiée.' );
    }

    public function deleteTask($task)
    {

        $this->entityManager->remove( $task );
        $this->entityManager->flush();

        $this->addFlash( 'success', 'La tâche a bien été supprimée.' );

    }
}