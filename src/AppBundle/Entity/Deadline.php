<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Todo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="deadline")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DeadlineRepository")
 */
class Deadline
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
     * @ORM\OneToMany(targetEntity="Todo", mappedBy="deadline", cascade={"persist"})
     */
    private $todo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $met = false;

    /**
     * @ORM\Column(type="text")
     */
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
