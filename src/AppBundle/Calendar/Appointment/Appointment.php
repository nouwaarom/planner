<?php

namespace AppBundle\Calendar\Appointment;

use AppBundle\Calendar\Todo\Todo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as REST;

/**
 * @REST\ExclusionPolicy("all")
 */
class Appointment
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

    /**
     * @REST\Expose
     */
    private $priority;

    public function __construct($description = null, \DateTime $epoch = null, $priority = 0)
    {
        $this->description = $description;
        $this->epoch = $epoch;
        $this->priority = $priority;
        $this->todo = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getDateTime()
    {
        return $this->epoch;
    }

    public function setDatetime(\DateTime $epoch)
    {
       $this->epoch = $epoch;
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
        $todo->setAppointment($this);
        $this->todo[] = $todo;
    }

    public function removeTodo(Todo $todo)
    {
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('description', new Assert\Type('string'));
        $metadata->addPropertyConstraint('description', new Assert\NotBlank());
    }
}
