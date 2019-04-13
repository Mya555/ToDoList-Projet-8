<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 09/04/2019
 * Time: 14:32
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskManager
{
    private $entityManager;
    /**
     * TaskManager constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager = $manager;
    }
    public function toggleTask(Task $task){
        $task->toggle( !$task->isDone() );
        $this->entityManager->flush();
    }
}