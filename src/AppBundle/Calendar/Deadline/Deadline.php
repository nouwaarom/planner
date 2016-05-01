<?php

namespace AppBundle\Calendar\Deadline;

use AppBundle\Calendar\Todo\Todo;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as REST;

/**
 * @REST\ExclusionPolicy("all")
 */
class Deadline
{
    /**
     * @REST\Expose
     */
    private $id;

    /**
     * @REST\Expose
     */
    private $description;

    /**
     * @REST\Expose
     */
    private $epoch;

    private $todo;

    private $met = false;

    private $reflection = "";

    private function __construct($description, \DateTime $epoch)
    {
        $this->description = $description;
        $this->epoch = $epoch;
        $this->todo = new ArrayCollection();
    }

    public static function plan($description, \DateTime $epoch)
    {
        return new self($description, $epoch);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEpoch()
    {
        return $this->epoch;
    }

    public function getDateTime()
    {
        return $this->epoch;
    }

    public function setEpoch(\DateTime $time)
    {
        $this->epoch = $time;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTodo()
    {
        return $this->todo->toArray();
    }

    public function addTodo(Todo $todo)
    {
        $todo->setDeadline($this);
        $this->todo[] = $todo;
    }

    public function removeTodo(Todo $todo)
    {
    }
}
