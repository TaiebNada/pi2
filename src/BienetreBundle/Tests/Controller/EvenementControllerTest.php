<?php

namespace BienetreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EvenementControllerTest extends WebTestCase
{
    public function testAjout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Ajout');
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Update');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Delete');
    }

    public function testRecherche()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/recherche');
    }

    public function testAffiche()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Affiche');
    }

}
