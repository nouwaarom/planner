<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="calendar_appointments")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AppointmentRepository")
 */
class Appointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $epoch;

    /**
     * @ORM\OneToMany(targetEntity="Todo", mappedBy="appointment", cascade={"persist"})
     */
    private $todo;

    /**
     * @ORM\Column(type="integer")
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
