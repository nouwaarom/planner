<?php

namespace AppBundle\Calendar\Activity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as REST;

/**
 * @ORM\Table(name="activities")
 * @REST\ExclusionPolicy("all")
 */
class Activity
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
     * @ORM\OneToMany(targetEntity="Todo", mappedBy="activity")
     * @REST\Expose
     */
    private $todos;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="activity")
     * @REST\Expose
     */
    private $activities;
}