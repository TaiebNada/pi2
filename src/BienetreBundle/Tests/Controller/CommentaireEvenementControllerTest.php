<?php

namespace BienetreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentaireEvenementControllerTest extends WebTestCase
{
    public function testAjout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Ajout');
    }

    public function testAffichecommentaire()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AfficheCommentaire');
    }

    public function testSupprimercommentaire()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/SupprimerCommentaire');
    }

    public function testUpdatecommentaire()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/UpdateCommentaire');
    }

}
