<?php

namespace AppBundle\Calendar;

use AppBundle\Calendar\Deadline\Deadline;

class CalendarExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array();
    }

    public function getTests()
    {
        return array(
            new \Twig_SimpleTest('deadline', array($this, 'isDeadline')),
        );
    }

    public function isDeadline($class)
    {
        if($class instanceof Deadline) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return 'calendar';
    }
}
