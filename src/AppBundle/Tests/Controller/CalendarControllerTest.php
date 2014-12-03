<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalendarControllerTest extends WebTestCase
{
    public function testShowAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/calendar');
        $crawler = $client->followRedirect();

        $this->assertCount(1, $crawler->filter('html:contains("I dont like pie")'));
    }
}
