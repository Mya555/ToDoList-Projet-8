<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testShowIndex()
    {
        $client = static::createClient();
        $crawler = $client->request( 'GET', '/' );

        $this->assertEquals( 200, $client->getResponse()->getStatusCode() );
        $this->assertContains( 'Bienvenue sur Todo List', $crawler->filter( '.container1 h1' )->text() );
    }

    public function testRedirectToTaskList()
    {

        $client = static::createClient();
        $crawler = $client->request( 'GET', '/' );

        $link = $crawler->selectLink( 'Consulter la liste des tâches à faire' )->link();
        $crawler = $client->click( $link );

        $info = $crawler->filter( 'h1' )->text();
        $info = $string = trim( preg_replace( '/\s\s+/', ' ', $info ) ); // On retire les retours à la ligne pour faciliter la vérification

        $this->assertSame( "Liste des tâches", $info );

    }
}


