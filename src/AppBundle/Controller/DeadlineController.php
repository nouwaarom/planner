<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\DeadlineType;
use AppBundle\Entity\Deadline;

/**
 * @Route("/deadline")
 */
class DeadlineController extends Controller
{
    /**
     * @Route("/new", name="new_deadline")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(new DeadlineType(), null, array(
            'action' => $this->generateUrl('new_deadline'),
        ));

        $form->handleRequest($request);
        
        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('list_calendar');
        }

        return $this->render('Deadline/new_form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
