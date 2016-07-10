<?php

namespace AppBundle\Calendar\Todo;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TodoStatsController extends Controller
{
    public function indexAction()
    {
        return $this->render('TodoStats/index.html.twig');
    }
}
