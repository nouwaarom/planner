<?php

namespace AppBundle\Calendar\Todo;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Calendar\Appointment\Appointment;
use AppBundle\Calendar\Deadline\Deadline;
use JMS\Serializer\Annotation as REST;

/**
 * @REST\ExclusionPolicy("all")
 */
class Todo
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
    private $appointment;

    /**
     * @REST\Expose
     */
    private $deadline;

    /**
     * @REST\Expose
     */
    private $done = 0;

    public function __construct($description)
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
        return ($this->done == 100) ? true : false;
    }

    public function hasBeenDone()
    {
        $this->done = 100;
    }

    public function isStarted()
    {
        return ($this->done > 0) ? true : false;
    }

    public function hasBeenStarted()
    {
        $this->done = 1;
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('description', new Assert\Type('string'));
        $metadata->addPropertyConstraint('description', new Assert\NotBlank());
        $metadata->addPropertyConstraint('done', new Assert\Type('integer'));
    }
}

