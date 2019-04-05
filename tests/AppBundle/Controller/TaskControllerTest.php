<?php
/**
 * Created by PhpStorm.
 * User: text_
 * Date: 30/03/2019
 * Time: 10:27
 */

namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testShowTaskListPage()
    {
        $client = static::createClient();
        $client->request( 'GET', '/tasks' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
    }

}