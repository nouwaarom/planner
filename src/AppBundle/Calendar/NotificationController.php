<?php

namespace AppBundle\Calendar;

use AppBundle\Calendar\Appointment\Appointment;
use AppBundle\Calendar\Deadline\Deadline;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    public function getNotificationsAction(\DateTime $date)
    {
        $appRepository =  $this->getDoctrine()->getRepository(Appointment::class);
        $deadRepository = $this->getDoctrine()->getRepository(Deadline::class);

        $appToday  = $appRepository->findFirst(new \DateTime('today'));
        $deadToday = $deadRepository->findFirst(new \DateTime('today'));

        return $this->render(
            'Notifications/notifications.html.twig',
             array(
                'notes' =>
                    array($appToday ?
                            "You got an appointment at: ". $appToday->getDateTime()->format('D H:i:s') :
                            "You are free!!",
                          $deadToday ?
                            "And a deadline at: ". $deadToday->getDateTime()->format('D H:i:s') :
                            "I missed the deadlines :(",
                 )
            )
        );
    }

}
