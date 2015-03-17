<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DeadlineRepository extends EntityRepository
{
    public function findDate(\DateTime $start)
    {
        $end = clone $start;
        $end->modify("+1 day");

        return $this->getEntityManager()->createQuery(
            'SELECT a
            FROM AppBundle:Deadline a
            WHERE a.epoch BETWEEN :start
            AND :end
            ORDER BY a.epoch ASC'
        )->setParameter('start', $start)
        ->setParameter('end', $end)
        ->getResult();
    }
}
