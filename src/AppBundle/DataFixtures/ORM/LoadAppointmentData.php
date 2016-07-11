<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use AppBundle\Calendar\Appointment\Appointment;

class LoadAppointmentData implements FixtureInterface
{
    public function load(ObjectManager $em)
    {
        $em->persist(new Appointment('Meeting at floor 4', new \DateTime('now + 3 days')));
        $em->persist(new Appointment('Lunch at Auditorium', new \DateTime('now + 1 days'), 10));
        $em->persist(new Appointment('Practical lessons', new \DateTime('now + 10 days')));
        $em->persist(new Appointment('Have a drink', new \DateTime('now - 3 days')));
        $em->persist(new Appointment('Lecture', new \DateTime('now')));
        $em->persist(new Appointment('Watch a movie', new \DateTime('now + 1 days'), 5));

        $em->flush();
    }
}
