<?php

namespace AppBundle\Calendar\Todo\Handler;

use Doctrine\ORM\EntityManager;
use AppBundle\Calendar\Todo\Todo;
use AppBundle\Calendar\Todo\Command\NewTodo;

class NewTodoHandler
{
    private $entitiyManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    //FIXME implement done variable handling
    public function handle(NewTodo $command)
    {
        $todo = new Todo($command->description());

        $this->entityManager->persist($todo);

        $this->entityManager->flush($todo);
    }
}