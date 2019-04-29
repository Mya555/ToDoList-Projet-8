<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class TaskManagerTest extends TestCase
{
    protected $entityManager;
    protected $task;
    protected $session;

    public function setUp()
    {
        $this->entityManager = $this->createMock( EntityManager::class );
        $this->task = new Task();
        $this->session = $this->createMock( Session::class );
    }

    public function testToggleTaskFlush()
    {
        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );

        $this->task->toggle( !$this->task->isDone() );
        $this->entityManager->flush();

        $this->assertEquals( true, $this->entityManager->flush() );
    }

    public function testAddFlashMessage()
    {
        $key = 'success';
        $message = 'message';

        $this->session->method( 'getFlashBag' );

        $this->session->getFlashBag( $key, $message );

        $this->assertEquals( 'success', $key );
        $this->assertEquals( 'message', $message );
    }

    public function testAddTaskDataBasePersistAndFlush()
    {
        $user = new User();

        $this->entityManager
            ->method( 'persist' )
            ->willReturn( true );

        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );

        $this->task->setUser( $user );

        $this->entityManager->persist( $this->task );
        $this->entityManager->flush();

        $this->assertEquals( true, $this->entityManager->persist( $this->task ) );
        $this->assertEquals( true, $this->entityManager->flush() );
    }

    public function testEditTask()
    {
        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );

        $this->entityManager->flush();
        $this->assertEquals( true, $this->entityManager->flush() );
    }

    public function testDeleteTaskRemoveAndFlush()
    {
        $this->entityManager
            ->method( 'remove' )
            ->willReturn( true );

        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );

        $this->entityManager->remove( $this->task );
        $this->entityManager->flush();

        $this->assertEquals( true, $this->entityManager->remove( $this->task ) );
        $this->assertEquals( true, $this->entityManager->flush() );
    }

    public function tearDown()
    {
        $this->entityManager = null;
        $this->task = null;
        $this->session = null;
    }
}