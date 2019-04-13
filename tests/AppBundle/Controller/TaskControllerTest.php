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

    public function testShowTaskList(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Task")')->count()
        );
    }

    public function testEditTask(){
        $client = static::createClient( [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'password'] );
        $crawler = $client->request( 'GET', '/tasks/182/edit' );

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'content_edit';
        $form['task[content]'] = 'content_edit';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Superbe ! La tâche a bien été modifiée.');
    }

    public function testCreateTask()
    {
        $client = static::createClient(array(), array('PHP_AUTH_USER'=>'admin', 'PHP_AUTH_PW'=>'password'));
        $crawler = $client->request('GET', '/tasks');
        $link = $crawler->selectLink('Créer une tâche')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->selectLink("Retour à la liste des tâches")->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'title';
        $form['task[content]'] = 'content';
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->selectLink("Créer une tâche")->count());
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Superbe ! La tâche a été bien été ajoutée.');

    }


   /* public function testDeleteTask()
    {
        $client = static::createClient( [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'password'] );
        $client->request( 'DELETE', '/tasks/{id}/delete' );
        $crawler = $client->request(
            'DELETE',
            '/tasks/184/delete',
            [],
            [],
            ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'password']
        );
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode() );
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Superbe ! La tâche a bien été supprimée.');

    }
*/
}