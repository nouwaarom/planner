<?php

namespace AppBundle\Controller;

use Calendar\Appointment;
use Calendar\Type\CalendarType;
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
     * @Route("/")
     */
    public function showAction()
    {
        $appointments = $this->getDoctrine()->getRepository('AppBundle:Appointment')->findAllAndOrderByDate();

        return $this->render('Calendar/show.html.twig', array(
            'appointments' => $appointments,
        ));
    }

    public function newAction(Request $request, Application $app)
    {
        $appointment = new Appointment();

        $form = $app['form.factory']->create(new CalendarType(), $appointment, array(
            'action' => $app['url_generator']->generate('new_calender'),
        ));

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $app['db']->insert('calendar_appointments', [
                'description' => $appointment->getDescription(),
                'time'        => $appointment->getDateTime()->format('Y-m-d H:i:s'),
                'priority'    => $appointment->getPriority(),
            ]);

            return $app->redirect($app['url_generator']->generate('list_calender'));
        }

        return $app['twig']->render('Calendar/new_form.twig', array(
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

