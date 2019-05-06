<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 30/03/2019
 * Time: 10:28
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    public function testShowUserListPage()
    {
        $client = static::createClient();
        $crawler = $client->request( 'GET', '/users' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
        $this->assertGreaterThan(
            0,
            $crawler->filter( 'html:contains("Liste des utilisateurs")' )->count()
        );
    }

    public function testCreateUser()
    {
        $client = static::createClient( array(), array('PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'password') );
        $crawler = $client->request( 'GET', '/users/create' );
        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
        $this->assertContains( 'Créer un utilisateur', $client->getResponse()->getContent() );

        $form = $crawler->selectButton( 'Ajouter' )->form();

        $form['user[username]'] = 'test_user';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'test@mail.com';
        $form['user[roles]'] = 'ROLE_ADMIN';
        $client->submit( $form );

        $crawler = $client->followRedirect();
        $this->assertTrue( $client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été ajouté.' );
        $this->assertContains( 'Liste des utilisateurs', $client->getResponse()->getContent() );

    }

    public function testEditUser()
    {
        $client = static::createClient( [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'password'] );

        $crawler = $client->request( 'GET', '/users' );
        $link = $crawler->selectLink( 'Edit' )->last()->link();
        $crawler = $client->click( $link );

        $form = $crawler->selectButton( 'Modifier' )->form();
        $form['user[username]'] = 'test_user_modif';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'test_user_modif@mail.com';
        $form['user[roles]'] = 'ROLE_ADMIN';
        $client->submit( $form );

        $crawler = $client->followRedirect();
        $this->assertTrue( $client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été modifié' );
        $this->assertContains( 'Liste des utilisateurs', $client->getResponse()->getContent() );

    }

}