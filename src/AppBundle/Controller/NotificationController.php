<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    public function getNotificationsAction(\DateTime $date)
    {
        return $this->render(
            'Notifications/notifications.html.twig',
             array('note' => "This is a sample Notification")
        );
    }

}
