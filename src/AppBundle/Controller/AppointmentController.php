<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Appointment;
use AppBundle\Form\AppointmentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/appointment")
 */
class AppointmentController extends Controller
{
    /**
     * @Route("/new", name="new_appointment")
     */
    public function newAction(Request $request)
    {
        $appointment = new Appointment();

        $form = $this->createForm(new AppointmentType(), $appointment, array(
            'action' => $this->generateUrl('new_appointment'),
        ));

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($appointment);

            $em->flush();

            return $this->redirectToRoute('list_calendar');
        }

        return $this->render('Appointment/new_form.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_appointment")
     */
    public function editAction(Appointment $appointment, Request $request)
    {
        $form = $this->createForm(new CalendarType(), $appointment);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('list_calendar');
        }

        return $this->render('Appointment/edit_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
