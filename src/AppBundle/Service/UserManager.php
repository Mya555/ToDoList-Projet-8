<?php


namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

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

    public function encryptPass($user)
    {
        $password = $this->get( 'security.password_encoder' )->encodePassword( $user, $user->getPassword() );
        return $password;
    }
}