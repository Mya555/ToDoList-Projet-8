<?php


namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserManager
{
    private $entityManager;
    private $passwordEncoder;
    private $session;

    public function __construct(EntityManager $manager, UserPasswordEncoderInterface $encoderPass, SessionInterface $session)
    {
        $this->passwordEncoder = $encoderPass;
        $this->entityManager = $manager;
        $this->session = $session;
    }

    public function createUser($user)
    {

        $password = $this->encryptPass( $user );
        $user->setPassword( $password );
        $this->entityManager->persist( $user );
        $this->entityManager->flush();
    }

    public function encryptPass($user)
    {
        $password = $this->passwordEncoder->encodePassword( $user, $user->getPassword() );
        return $password;
    }

    public function editUser($user)
    {
        $password = $this->encryptPass( $user );
        $user->setPassword($password);

        $this->entityManager->flush();

        $this->session->getFlashBag()->add('success', "L'utilisateur a bien été modifié");

    }
}