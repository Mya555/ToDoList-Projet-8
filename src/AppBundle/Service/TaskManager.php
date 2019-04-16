<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 09/04/2019
 * Time: 14:32
 */

namespace AppBundle\Service;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;


class TaskManager
{
    private $entityManager;

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    public function toggleTask($task)
    {
        $task->toggle( !$task->isDone() );
        $this->entityManager->flush();
    }

    public function addTask(Request $request)
    {



    }

}