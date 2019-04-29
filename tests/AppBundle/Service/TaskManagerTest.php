<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class TaskManagerTest extends TestCase
{
    public function testToggleTask()
    {
        $entityManager = $this->createMock(EntityManager::class);
        $entityManager
            ->method('flush')
            ->willReturn(true);

        $task = new Task();
        $task->toggle( !$task->isDone() );
        $entityManager->flush();

       $this->assertEquals( true , $entityManager->flush());
    }
}