<?php

namespace AppBundle\Calendar\Todo\Command;

use SimpleBus\Message\Name\NamedMessage;

/**
 * Class NewTodo
 * @package AppBundle\Calendar\Todo\Command
 */
class NewTodo implements NamedMessage
{
    private $done;
    private $description;

    public function __construct($description, $done)
    {
        $this->description = $description;
        $this->done = $done;
    }

    public function description()
    {
        return $this->description;
    }

    public function done()
    {
        return $this->done;
    }

    public static function messageName()
    {
        return 'new_todo';
    }
}