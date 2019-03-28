<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 28/03/2019
 * Time: 10:45
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){

        // Create user with role ROLE_ADMIN
        $user_admin = new User();
        $user_admin->setUsername( 'admin' );
        $user_admin->setPassword($this->container->get('security.password_encoder')->encodePassword($user_admin, 'password' ));
        $user_admin->setEmail( 'admin@mail.fr' );
        $user_admin->setRoles( array('ROLE_ADMIN') );
        $manager->persist( $user_admin );

        // Create user with role ROLE_USER
        $user_user = new User();
        $user_user->setUsername( 'user' );
        $user_user->setPassword($this->container->get('security.password_encoder')->encodePassword($user_user, 'password' ) );
        $user_user->setEmail( 'user@mail.fr' );
        $user_user->setRoles( array('ROLE_USER') );
        $manager->persist( $user_user );


        // 5 tasks without a user
        for ($i = 0; $i < 5; $i++) {
            $task = new Task();
            $task->setTitle( 'Task with User is null n° ' . $i );
            $task->setContent( '
                Icing liquorice liquorice I love chocolate cake tart
                croissant chocolate sugar plum. 
                Danish sugar plum carrot cake chocolate bar chocolate bar carrot cake. 
                I love macaroon pudding topping jelly cookie soufflé.' );
            $manager->persist( $task );
        }
        // 5 tasks attached to a user with ROLE_USER
        for ($i = 0; $i < 5; $i++) {
            $task = new Task();
            $task->setTitle( 'Task with User with ROLE_USER n° ' . $i );
            $task->setContent( '
                Caramels I love biscuit jelly I love carrot cake gingerbread. 
                I love sweet pudding ice cream topping oat cake sweet marzipan.
                Donut marshmallow donut dragée chocolate cake cake. Powder 
                chocolate cake apple pie chupa chups biscuit I love chocolate cake.' );
            $task->setUsers( $user_user );
            $manager->persist( $task );
        }
        // 5 tasks attached to a user with ROLE_ADMIN
        for ($i = 0; $i < 5; $i++) {
            $task = new Task();
            $task->setTitle( 'Task with User with ROLE_ADMIN n° ' . $i );
            $task->setContent( '
                pple pie bonbon marshmallow chupa chups liquorice sesame snaps 
                I love pudding icing. Caramels danish brownie lemon drops icing. 
                Caramels I love liquorice caramels tart. Topping carrot cake danish tart.' );
            $task->setUsers( $user_admin );
            $manager->persist( $task );
        }

        $manager->flush();
    }
}