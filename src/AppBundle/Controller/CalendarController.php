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

        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($appointment);

            $em->flush();

            return $this->redirectToRoute('list_calendar');
        }

        return $this->render('Calendar/new_form.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id, Application $app, Request $request)
    {
        $appointment = $this->populateAppointment(
            $app['db']->fetchAssoc('SELECT id, description, time, priority FROM calendar_appointments WHERE id=?', array($id))
        );

        $form = $app['form.factory']->create(new CalendarType(), $appointment);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $app['db']->update('calendar_appointments', array(
                'description' => $appointment->getDescription(),
                'time'        => $appointment->getDateTime()->format('Y-m-d H:i:s'),
                'priority'    => $appointment->getPriority(),
            ), array('id' => $id));

            return $app->redirect($app['url_generator']->generate('list_calender'));
        }

        return $app['twig']->render('Calendar/edit_form.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function populateAppointment($data)
    {
        $appointment = new Appointment($data['description'], new \DateTime($data['time']), $data['priority']);
        $appointment->setId($data['id']);

        return $appointment;
    }
} 

