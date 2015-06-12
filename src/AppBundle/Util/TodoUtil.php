<?php

namespace AppBundle\Util;

use AppBundle\Entity\Todo;

class TodoUtil
{
    /**
     * @param Todo[] $items
     *
     * @return array An array containing 2 elements, one array of all items that have not been done and one of all items that have been done
     */
    public function groupByDone(array $items)
    {
        $grouped = array('done' => array(), 'undone' => array());

        foreach ($items as $item) {
            if($item->isDone())
                $grouped['done'][] = $item;
            else
                $grouped['undone'][] = $item; 
        }

        return $grouped;
    }
}
