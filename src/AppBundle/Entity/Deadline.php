<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="deadline") 
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
     * @ORM\Column(type="string", length="64")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length="255")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $epoch;

    /**
     * @OneToMany(targetEntity="Todo")
     */
    private $todo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $met;

    /**
     * @ORM\Column(type="text")
     */
    private $reflection;
}

