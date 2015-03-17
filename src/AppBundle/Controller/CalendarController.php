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

        $todo = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();

        return $this->render('Calendar/show.html.twig', array(
            'today' => $today,
            'tomorrow' => $tomorrow,
            'overmorrow' => $overmorrow,
            'todo' => $todo,
        ));
    }

    private function sortByTime($appointments, $deadlines)
    {
        $sorted = array();
    
        foreach ($appointments as $appointment)
        {
            foreach ($deadlines as $key => $deadline) {
                if ($deadline->getDateTime() < $appointment->getDateTime()) {
                    $sorted[] = $deadline;
                    unset($deadlines[$key]);
                }
            }

            $sorted[] = $appointment;
        }

        return $sorted;
    }
} 
