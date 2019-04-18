<?php


namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{

    public function createUser($user)
    {
        $em = $this->getDoctrine()->getManager();
        $password = $this->encryptPass( $user );
        $user->setPassword( $password );

        $em->persist( $user );
        $em->flush();
    }

    public function encryptPass($user,  UserPasswordEncoderInterface $encoderPass)
    {
        $password = $this->encoderPass->encodePassword( $user, $user->getPassword() );
        return $password;
    }
}