<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class TaskTest extends TestCase
{
    protected $user;
    protected $task;

    public function setUp()
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function tearDown()//all variables are  null at each end of the test so that the system memory is not overloaded
    {
        $this->user = null;
        $this->task = null;
    }

    public function testTaskTitle()
    {

        $this->task->setTitle( 'Test title' );
        $this->assertEquals( $this->task->getTitle(), 'Test title' );
    }

    public function testTaskContent()
    {
        $this->task->setContent( 'Test content' );
        $this->assertEquals( $this->task->getContent(), 'Test content' );
    }

    public function testTaskUser()
    {
        $this->task->setUser( $this->user );
        $this->assertEquals( $this->task->getUser(), $this->user );
    }

    public function testTaskDate()
    {
        $date = new DateTime();
        $this->task->setCreatedAt( $date );
        $this->assertEquals( $this->task->getCreatedAt(), $date );
    }
}