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

    public function testNewAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/calendar/new');

        $form = $crawler->selectButton('Submit')->form();
        $form['calendar[description]'] = 'Lorem ipsum dolor mir submit a form.';

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertCount(1, $crawler->filter('html:contains("Lorem ipsum dolor mir submit a form.")'));
    }
}
