<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 30/03/2019
 * Time: 10:27
 */

namespace Tests\AppBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SecurityControllerTest extends WebTestCase
{
    public function testShowLoginPage()
    {
        $client = static::createClient();
        $client->request( 'GET', '/login' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
    }

    public function testLoginForm()
    {
        $client = static::createClient([], ['PHP_AUTH_USER'=>'admin', 'PHP_AUTH_PW'=>'password']);
        $client->request('GET', '/login');
        $client->request('GET', '/', [], [], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);
        $this->assertFalse($client->getResponse()->isRedirect());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Todo List', $client->getResponse()->getContent());
    }
}