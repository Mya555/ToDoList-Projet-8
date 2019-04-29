<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class UserManagerTest extends TestCase
{
    protected $entityManager;
    protected $session;
    protected $passwordEncoder;
    protected $user;

    public function setUp()
    {
        $this->user = new User();
        $this->entityManager = $this->createMock( EntityManager::class );
        $this->session = $this->createMock( Session::class );
        $this->passwordEncoder = $this->createMock( PasswordEncoderInterface::class );
    }

    public function testPasswordEncoder()
    {
        $password = $this->passwordEncoder->encodePassword( $this->user, $this->user->getPassword() );

        $this->assertEquals( $this->passwordEncoder->encodePassword( $this->user, $this->user->getPassword() ), $password );
    }

    public function testCreateUser()
    {
        $task = new Task();
        $this->entityManager
            ->method( 'persist' )
            ->willReturn( true );

        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );

        $password = $this->passwordEncoder->encodePassword( $this->user, $this->user->getPassword() );
        $this->user->setPassword( $password );
        $this->entityManager->persist( $this->user );
        $this->entityManager->flush();

        $this->assertNotEquals( $this->user, $this->user->getPassword() );
        $this->assertEquals( true, $this->entityManager->persist( $task ) );
        $this->assertEquals( true, $this->entityManager->flush() );
    }

    public function testEditUser()
    {
        $this->entityManager
            ->method( 'flush' )
            ->willReturn( true );

        $password = $this->passwordEncoder->encodePassword( $this->user, $this->user->getPassword() );
        $this->user->setPassword( $password );

        $this->entityManager->flush();

        $this->assertNotEquals( $this->user, $this->user->setPassword( $password ) );
        $this->assertEquals( true, $this->entityManager->flush() );

    }


    public function tearDown()
    {
        $this->entityManager = null;
        $this->passwordEncoder = null;
        $this->session = null;
    }
}