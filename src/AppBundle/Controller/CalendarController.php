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
     * @Route("/{start}", defaults={"start"=0} , name="list_calendar")
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
            $days[$i] = $this->sortByTime($day, $deadDay);

            $titles[$i] = $date->format('l');

            $date->modify('+1 day');
        }

        //Get the deadlines
        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAllItemsThatAreNotDone();

        //Pass everything to the template
        return $this->render('Calendar/show.html.twig', array(
            'day1' => array_shift($days),
            'day2' => array_shift($days),
            'day3' => array_shift($days),
            'day1title' => array_shift($titles),
            'day2title' => array_shift($titles),
            'day3title' => array_shift($titles),
            'todo' => array_shift($days),
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
