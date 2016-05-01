<?php

namespace AppBundle\Calendar\Todo;

use Doctrine\ORM\EntityRepository;
use AppBundle\Calendar\Todo\Todo;

class TodoRepository extends EntityRepository
{
    public function findAllItemsThatAreNotActive()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->select('t')
                ->from(Todo::class, 't')
                ->where('t.done = ?1')
                ->setParameter(1, 0)
                ->getQuery();

        return $q->getResult();
    }

    public function findAllItemsThatAreActiveAndNotDone()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->select('t')
            ->from(Todo::class, 't')
            ->where('t.done != ?1')
            ->andWhere('t.done != ?2')
            ->setParameter(1, 0)
            ->setParameter(2, 100)
            ->getQuery();

        return $q->getResult();
    }

    public function findAllItemsThatAreDone()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->select('t')
            ->from(Todo::class, 't')
            ->where('t.done = ?1')
            ->setParameter(1, 100)
            ->getQuery();

        return $q->getResult();
    }
}
