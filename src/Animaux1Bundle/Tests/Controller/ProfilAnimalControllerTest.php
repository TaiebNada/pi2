<?php

namespace Animaux1Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilAnimalControllerTest extends WebTestCase
{
    public function testAjoutprofil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajoutProfil');
    }

}
