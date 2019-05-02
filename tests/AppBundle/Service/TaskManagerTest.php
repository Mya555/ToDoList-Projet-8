<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Service\TaskManager;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;


class TaskManagerTest extends TestCase
{
    protected $entityManager;
    protected $task;
    protected $session;
    protected $taskManager;
    protected $user;

    public function setUp()
    {
        $this->entityManager = $this->createMock( EntityManager::class );
        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );
        $this->entityManager
            ->method( 'persist' )
            ->willReturn( true );
        $this->entityManager
            ->method( 'remove' )
            ->willReturn( true );

        $this->task = new Task();
        $this->user = new User();

        $this->session = $this->createMock( Session::class );
        $this->session->method( 'getFlashBag' )
            ->willReturn( new FlashBag() );

        $this->taskManager = new TaskManager( $this->entityManager, $this->session );
    }

    public function tearDown()
    {
        $this->user = null;
        $this->entityManager = null;
        $this->task = null;
        $this->session = null;
        $this->taskManager = null;
    }

    public function testToggleTaskIsdone()
    {
        $this->task->toggle( true );

        $this->taskManager->toggleTask( $this->task );
        $this->assertEquals( false, $this->task->isDone() );

        $this->taskManager->toggleTask( $this->task );
        $this->assertEquals( true, $this->task->isDone() );
    }


    public function testIfAddTaskTakeTheRightUser()
    {
        $this->taskManager->addTask( $this->task, $this->user );
        $this->assertEquals( $this->user, $this->task->getUser() );
    }

    public function testEditTaskHasOnceFlushOnceGetflashbag()
    {
        $this->entityManager
            ->expects( $this->exactly( 1 ) )
            ->method( 'flush' );
        $this->session
            ->expects( $this->exactly( 1 ) )
            ->method( 'getFlashBag' );

        $this->taskManager->editTask();
    }

    public function testDeleteIfOnceRemoveOnceFlush()
    {
        $this->user->setRoles( 'ROLE_ADMIN' );
        $this->task->setUser( $this->user );

        $this->entityManager
            ->expects( $this->exactly( 1 ) )
            ->method( 'remove' );
        $this->entityManager
            ->expects( $this->exactly( 1 ) )
            ->method( 'flush' );

        $this->taskManager->deleteTask( $this->task );
    }
}
