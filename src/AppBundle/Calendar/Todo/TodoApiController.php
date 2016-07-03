<?php

namespace AppBundle\Calendar\Todo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Calendar\Todo\Todo;

class TodoApiController extends Controller
{
    public function indexTodoAction()
    {
        $todos = $this->getDoctrine()->getRepository(Todo::class)->findAllItemsThatAreNotActive();

        $json = $this->get('serializer')->serialize($todos, 'json');

        $jsonResponse = new Response($json);
        $jsonResponse->headers->set('Content-Type', 'application/json');

        return $jsonResponse;
    }

    public function indexDoingAction()
    {
        $todos = $this->getDoctrine()->getRepository(Todo::class)->findAllItemsThatAreActiveAndNotDone();

        $json = $this->get('serializer')->serialize($todos, 'json');

        $jsonResponse = new Response($json);
        $jsonResponse->headers->set('Content-Type', 'application/json');

        return $jsonResponse;
    }

    public function indexDoneAction()
    {
        $dones = $this->getDoctrine()->getRepository(Todo::class)->findAllItemsThatAreDone();

        $json = $this->get('serializer')->serialize($dones, 'json');

        $jsonResponse = new Response($json);
        $jsonResponse->headers->set('Content-Type', 'application/json');

        return $jsonResponse;
    }

    public function getAction(Todo $todo)
    {
        $jsonResponse = new Response($this->get('serializer')->serialize($todo, 'json'));
        $jsonResponse->headers->set('Content-Type', 'application/json');

        return $jsonResponse;
    }

    public function startTodoAction(Todo $todo, Request $request)
    {
        $todo->hasBeenStarted();

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(array(
            'status' => 'ok',
        ));
    }

    public function markDoneAction(Todo $todo, Request $request)
    {
        $todo->hasBeenDone();

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(array(
            'status' => 'ok',
        ));
    }

    public function deleteTodoAction(Todo $todo, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($todo);
        $em->flush();

        return new JsonResponse(array(
            'status' => 'ok',
        ));
    }
}
