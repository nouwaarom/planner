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
        $appointments = $this->getDoctrine()->getRepository('AppBundle:Appointment')->findAllAndOrderByDate();

        return $this->render('Calendar/show.html.twig', array(
            'appointments' => $appointments,
        ));
    }

    /**
     * @Route("/new", name="new_calendar")
     */
    public function newAction(Request $request)
    {
        $appointment = new Appointment();

        $form = $this->createForm(new CalendarType(), $appointment, array(
            'action' => $this->generateUrl('new_calendar'),
        ));

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($appointment);

            $em->flush();

            return $this->redirectToRoute('list_calendar');
        }

        return $this->render('Calendar/new_form.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_calendar")
     */
    public function editAction(Appointment $appointment, Request $request)
    {
        $form = $this->createForm(new CalendarType(), $appointment);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('list_calendar');
        }

        return $this->render('Calendar/edit_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
} 
