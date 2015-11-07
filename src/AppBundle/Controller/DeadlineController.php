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
            'include_referer_url' => true,
        ));

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($form->get('_redirect_url')->getData() ?: $this->generateUrl('list_calendar'));
        }

        return $this->render('Deadline/new_form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit_deadline")
     */
    public function editAction(Deadline $deadline, Request $request)
    {
        $form = $this->createForm(new DeadlineType(), $deadline, array(
            'include_referer_url' => true,
        ));

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($form->get('_redirect_url')->getData() ?: $this->generateUrl('list_calendar'));
        }

        return $this->render('Deadline/edit_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
