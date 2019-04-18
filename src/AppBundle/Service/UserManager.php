<?php


namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManager $manager, UserPasswordEncoderInterface $encoderPass)
    {
        $this->passwordEncoder = $encoderPass;
        $this->entityManager = $manager;
    }

    public function createUser($user)
    {

        $password = $this->encryptPass( $user );
        $user->setPassword( $password );
        $this->entityManager->persist( $user )->flush();
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

        $this->addFlash('success', "L'utilisateur a bien été modifié");

    }
}