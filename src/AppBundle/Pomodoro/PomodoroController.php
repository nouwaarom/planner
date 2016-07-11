<?php
/**
 * Created by PhpStorm.
 * User: elbert
 * Date: 10/07/16
 * Time: 21:43
 */

namespace AppBundle\Pomodoro;

use AppBundle\Calendar\Appointment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PomodoroController extends Controller
{
    public function showAction()
    {
        return $this->render('Pomodoro/show.html.twig');
    }
}