<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Appointment;
use AppBundle\Entity\Deadline;

/**
 * @Route("/api/calendar")
 */
class CalendarApiController extends Controller
{
    /**
     * @Route("/")
     * Needs start and end request parameters
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Appointment');
        $deadRepository = $this->getDoctrine()->getRepository('AppBundle:Deadline');

        //Create a datetime object with the right date
        $date = new \DateTime($request->query->get('start'));
        $endDate   = new \DateTime($request->query->get('end'));

        //Get the appointments and deadlines per day
        $days = array();
        for ($i=0; $i<7; $i++)
        {
            $day = $repository->findDate($date);
            $deadDay = $deadRepository->findDate($date);

            $days[$date->format('l')] = $this->sortByTime($day, $deadDay);

            if($date < $endDate) {
                $date->modify('+1 day');
            }
        }

        $json = $this->get('serializer')->serialize($days, 'json');
        $jsonResponse = new Response($json);
        $jsonResponse->headers->set('Content-Type', 'application/json');

        return $jsonResponse;
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
