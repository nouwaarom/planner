<?php

namespace AppBundle\Calendar\Deadline;

use Doctrine\ORM\EntityRepository;
use AppBundle\Calendar\Deadline\Deadline;

class DeadlineRepository extends EntityRepository
{
    public function findDate(\DateTime $start)
    {
        $end = clone $start;
        $end->modify("+1 day");

        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->select('d')
            ->from(Deadline::class, 'd')
            ->where('d.epoch BETWEEN ?1 AND ?2')
            ->setParameter(1, $start)
            ->setParameter(2, $end)
            ->getQuery();

        return $q->getResult();
    }

    public function findFirst(\DateTime $after)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->select('d')
            ->from(Deadline::class, 'd')
            ->where('d.epoch > ?1')
            ->setParameter(1, $after)
            ->setMaxResults(1)
            ->getQuery();

        return $q->getResult();
    }
}
