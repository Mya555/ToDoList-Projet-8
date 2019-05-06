<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Service\UserManager;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\HttpFoundation\Session\Session;


class UserManagerTest extends TestCase
{
    protected $entityManager;
    protected $session;
    protected $passwordEncoder;
    protected $user;
    protected $task;
    protected $userManager;


    public function setUp()
    {
        $this->user = new User();
        $this->task = new Task();
        $this->entityManager = $this->createMock( EntityManager::class );
        $this->entityManager
            ->method( 'persist' )
            ->willReturn( true );

        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );

        $this->session = $this->createMock( Session::class );

        $this->passwordEncoder = $this->createMock( UserPasswordEncoder::class );
        $this->passwordEncoder->method( 'encodePassword' )->willReturn( 'test' );

        $this->userManager = new UserManager( $this->entityManager, $this->passwordEncoder, $this->session );
    }

    public function tearDown()
    {
        $this->entityManager = null;
        $this->passwordEncoder = null;
        $this->session = null;
        $this->user = null;
        $this->userManager = null;
    }

        public function testUserPassAndEncryptPassAreSame()
        {
            $this->userManager->createUser($this->user);
            $this->assertEquals( $this->userManager->encryptPass($this->user), $this->user->getPassword());
        }

        public function testEditUser()
        {

            $this->entityManager
                ->expects( $this->exactly( 1 ) )
                ->method( 'flush' );

            $this->userManager->editUser( $this->user );
        }

}