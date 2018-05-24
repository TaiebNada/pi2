<?php

namespace Animaux1Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReclamationVetControllerTest extends WebTestCase
{
    public function testAjoutreclamationa()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'ajoutReclamation');
    }

}
