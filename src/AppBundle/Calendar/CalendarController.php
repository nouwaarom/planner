<?php

namespace AppBundle\Calendar;

use AppBundle\Calendar\Appointment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CalendarController extends Controller
{
    public function showAction()
    {
        return $this->render('Calendar/show.html.twig');
    }
}
