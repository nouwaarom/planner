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
        $deadRepository = $this->getDoctrine()->getRepository('AppBundle:Deadline');

        $today = $repository->findDate(new \DateTime('today'));
        $deadToday = $deadRepository->findDate(new \DateTime('today'));
        $today = $this->sortByTime($today, $deadToday);

        $tomorrow = $repository->findDate(new \DateTime('tomorrow'));
        $deadTomorrow = $deadRepository->findDate(new \DateTime('tomorrow'));
        $tomorrow = $this->sortByTime($tomorrow, $deadTomorrow);

        $overmorrow = $repository->findDate(new \DateTime('+ 2 days'));
        $deadOvermorrow = $deadRepository->findDate(new \DateTime('+2 days'));
        $overmorrow = $this->sortByTime($overmorrow, $deadOvermorrow);

        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAllItemsThatAreNotDone();

        return $this->render('Calendar/show.html.twig', array(
            'today' => $today,
            'tomorrow' => $tomorrow,
            'overmorrow' => $overmorrow,
            'todo' => $todo,
        ));
    }

    private function sortByTime($appointments, $deadlines)
    {
        $sorted = array_merge($appointments, $deadlines);

        usort( $sorted, array($this, 'compare_dates') );

        return $sorted;
    }

    public function compare_dates($a, $b)
    {
        if( $a->getDateTime() > $b->getDateTime() )
            return 1;
        else
            return -1;
    }
} 
