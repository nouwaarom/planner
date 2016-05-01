<?php

namespace AppBundle\Authentication;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    public function showAction()
    {
        return $this->redirectToRoute('list_calendar');
    }
}
