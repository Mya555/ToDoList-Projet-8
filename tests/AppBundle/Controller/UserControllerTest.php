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
        $client->request( 'GET', '/users' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
    }
}