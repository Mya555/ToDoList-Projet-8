<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected $user;
    protected $task;

    public function setUp()
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function testUserUsername()
    {
        $this->user->setUsername( 'Test name' );
        $this->assertEquals( $this->user->getUsername(), 'Test name' );
    }

    public function testUserEmail()
    {
        $this->user->setEmail( 'email@testcom' );
        $this->assertEquals( $this->user->getEmail(), 'email@testcom' );
    }

    public function testUserPassword()
    {
        $this->user->setPassword( 'passeword' );
        $this->assertEquals( $this->user->getPassword(), 'passeword' );
    }

    public function testUserRole()
    {
        $this->user->setRoles( ['ROLE_ADMIN'] );
        $this->assertEquals( $this->user->getRoles(), ['ROLE_ADMIN'] );
    }

    public function testUsersTask()
    {
        $this->user->setTasks( $this->task );
        $this->assertEquals( $this->user->getTasks(), $this->task );
    }

    public function tearDown()
    {
        $this->user = null;
        $this->task = null;
    }

}