<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use AppBundle\Form\TodoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/todo")
 */
class TodoController extends Controller
{
    /**
     * @Route("/", name="list_todo")
     */
    public function showAction()
    {
        $items = $this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();

        return $this->render('Todo/list.html.twig', array(
            'items' => $items 
        ));
    }

    /**
     * @Route("/new", name="new_todo")
     */
    public function newAction(Request $request)
    {
        $todo = new Todo();

        $form = $this->createForm(new TodoType(), $todo, array(
            'action' => $this->generateUrl('new_todo'),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            return $this->redirectToRoute('list_todo');
        }

        return $this->render('Todo/new_form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit")
     * @Method({"POST"})
     */
    public function editAction(Request $request)
    {
        $recievedItemIDs = $request->request->get('items');
        if($recievedItemIDs)
        {
            $em = $this->getDoctrine()->getManager();
            $repo = $this->getDoctrine()->getRepository('AppBundle:Todo');

            foreach ($recievedItemIDs as $recievedItemID) {
                $todo = $repo->find($recievedItemID);
                dump($todo);
                $em->remove($todo);
            }
            $em->flush();
        }

        return $this->redirectToRoute('list_todo');
    }
}

