<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use AppBundle\Form\TodoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/{id}/edit", name="edit_todo")
     */
    public function editAction(Request $request, Application $app)
    {
        $recievedItemIDs = $request->request->get('id');

        $data = $this->fetchAll();

        // todo dit is slecht
        foreach ($data as $id => $item) {
            if (in_array($id, $recievedItemIDs)) {
                //if our item is done we dont need to store it
                unset($data[$id]);
            } else {
                $data[$id]->setDone(false);
            }
        }

        $app['todo.storage']->removeAll();
        foreach ($data as $d) {
            $app['todo.storage']->persist($d);
        }

        return $app['twig']->render('Todo/edit_success.twig', array(
            'amountOfDoneItems' => count($recievedItemIDs),
        ));
    }
}

