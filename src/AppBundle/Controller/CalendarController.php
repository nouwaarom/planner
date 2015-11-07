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
     * @Route("/{start}", defaults={"start": 0} , requirements={"start": "-?[0-9]*"}, name="list_calendar")
     */
    public function showAction($start)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Appointment');
        $deadRepository = $this->getDoctrine()->getRepository('AppBundle:Deadline');

        $days = array();
        $titles = array();

        //Create a datetime object with the right date
        $date = new \DateTime('today');
        if ($start > 0) {
            $date->modify('+ ' . $start . ' days');
        }
        else if ($start < 0) {
            $date->modify('- ' . abs($start) . ' days');
        }

        //Get the appointments and deadlines per day
        for ($i=0; $i<3; $i++)
        {
            $day = $repository->findDate($date);
            $deadDay = $deadRepository->findDate($date);
            $days[$date->format('l')] = $this->sortByTime($day, $deadDay);

            $date->modify('+1 day');
        }

        //Get the deadlines
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAllItemsThatAreNotDone();

        //Pass everything to the template
        return $this->render('Calendar/show.html.twig', array(
            'days' => $days,
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
