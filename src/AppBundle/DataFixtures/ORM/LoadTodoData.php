<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use AppBundle\Entity\Todo;

class LoadTodoData implements FixtureInterface
{
    public function load(ObjectManager $em)
    {
        $em->persist(new Todo('Meeting at floor 4'));
        $em->persist(new Todo('Lunch at Auditorium'));
        $em->persist(new Todo('Practical lessons'));
        $em->persist(new Todo('Have a drink'));
        $em->persist(new Todo('Lecture'));
        $em->persist(new Todo('Watch a movie'));

        $em->flush();
    }
}
