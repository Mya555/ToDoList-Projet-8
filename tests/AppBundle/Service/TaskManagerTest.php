<?php


namespace Tests\AppBundle\Service;

use AppBundle\Controller\TaskController;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Service\TaskManager;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;


class TaskManagerTest extends TestCase
{
    protected $entityManager;
    protected $task;
    protected $session;
    protected $taskManager;

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

        $this->session = $this->createMock( Session::class );
        $this->session->method( 'getFlashBag' )
            ->willReturn( new FlashBag() );

        $this->taskManager = new TaskManager( $this->entityManager, $this->session );
    }

    public function tearDown()
    {
        $this->entityManager = null;
        $this->task = null;
        $this->session = null;
        $this->taskManager = null;
    }

    public function testToggleTaskFlush()
    {
        $this->task->toggle( true );

        $this->taskManager->toggleTask( $this->task );
        $this->assertEquals( false, $this->task->isDone() );

        $this->taskManager->toggleTask( $this->task );
        $this->assertEquals( true, $this->task->isDone() );
    }


    public function testIfAddTaskTakeTheRightUser()
    {
        $user = new User();
        $this->taskManager->addTask( $this->task, $user );
        $this->assertEquals( $user, $this->task->getUser() );
    }


   /* public function testEditTask()
    {
        $controller = new TaskController();
        $request = new Request();


        $controller->editAction( $this->task, $request );


    }*/

    public function testDelete()
    {
        $user = new User();
        $user->setRoles( 'ROLE_ADMIN' );
        $this->task->setUser( $user );

        $this->taskManager->deleteTask( $this->task );

        // $this->assertSame( 0, $this->task );
        $this->assertEquals( true, $this->taskManager->deleteTask( $this->task ) );
    }
}
