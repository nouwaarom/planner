<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Todo;

/**
 * @Route("/api/todo")
 */
class TodoApiController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();

        $json = $this->get('serializer')->serialize($todos, 'json');

        $jsonResponse = new Response($json);
        $jsonResponse->headers->set('Content-Type', 'application/json');

        return $jsonResponse;
    }

    /**
     * @Route("/{id}")
     */
    public function getAction(Todo $todo)
    {
        $jsonResponse = new Response($this->get('serializer')->serialize($todo, 'json'));
        $jsonResponse->headers->set('Content-Type', 'application/json');

        return $jsonResponse;
    }

    /**
     * @Route("/mark_done/{id}")
     * @Method("POST")
     */
    public function markDoneAction(Todo $todo, Request $request)
    {
        $todo->hasBeenDone();

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(array(
            'status' => 'ok',
        ));
    }

    /**
     * @Route("/delete_todo/{id}")
     * @Method("POST")
     */
    public function deleteTodo(Todo $todo, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($todo);
        $em->flush();

        return new JsonResponse(array(
            'status' => 'ok',
        ));
    }
}
