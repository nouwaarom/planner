<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Appointment;
use JMS\Serializer\Annotation as REST;

/**
 * @ORM\Table(name="todo_items")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TodoRepository")
 * @REST\ExclusionPolicy("all")
 */
class Todo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @REST\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @REST\Expose
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Appointment", inversedBy="todo")
     * @REST\Expose
     */
    private $appointment;

    /**
     * @ORM\ManyToOne(targetEntity="Deadline", inversedBy="todo")
     * @REST\Expose
     */
    private $deadline;

    /**
     * @ORM\Column(type="boolean")
     * @REST\Expose
     */
    private $done = false;

    private function __construct($description)
    {
        $this->description = $description;
    }

    public static function writeDown($description)
    {
        return new static($description);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getAppointment()
    {
        return $this->appointment;
    }

    public function setAppointment(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline(Deadline $deadline)
    {
        $this->deadline = $deadline;
    }

    public function isDone()
    {
        return $this->done;
    }

    public function hasBeenDone()
    {
        $this->done = true;
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('description', new Assert\Type('string'));
        $metadata->addPropertyConstraint('description', new Assert\NotBlank());
        $metadata->addPropertyConstraint('done', new Assert\Type('bool'));
    }
}

