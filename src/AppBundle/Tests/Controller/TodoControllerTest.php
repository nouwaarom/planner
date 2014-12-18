<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoControllerTest extends WebTestCase
{
    public function testRemove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/todo');

        $form = $crawler->selectButton('submit')->form();
        $form['0']->tick();

        $resultPage = $client->submit($form);

        $this->assertCount(1, $resultPage->filter('html:contains("Todo list")'));
        $this->assertCount(0, $resultPage->filter('html:contains("Meeting at floor 4")'));
    }
}
