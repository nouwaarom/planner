<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Appointment;
use AppBundle\Form\CalendarType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * @Route("/", name="list_calendar")
     */
    public function showAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Appointment');

        $today = $repository->findDate(new \DateTime('today'));
        $tomorrow = $repository->findDate(new \DateTime('tomorrow'));
        $overmorrow = $repository->findDate(new \DateTime('+ 2 days'));

        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();

        return $this->render('Calendar/show.html.twig', array(
            'today' => $today,
            'tomorrow' => $tomorrow,
            'overmorrow' => $overmorrow,
            'todo' => $todo,
        ));
    }
} 
