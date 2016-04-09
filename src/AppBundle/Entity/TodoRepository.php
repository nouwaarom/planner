<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TodoRepository extends EntityRepository
{
    public function findAllItemsThatAreNotActive()
    {
        return $this->getEntityManager()->createQuery(
                'SELECT t FROM AppBundle:Todo t WHERE t.done = :notdone'
            )
            ->setParameter('notdone', 0)
            ->getResult();
    }

    public function findAllItemsThatAreActiveAndNotDone()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT t FROM AppBundle:Todo t WHERE t.done != :notdone AND t.done != :done'
        )
            ->setParameter('notdone', 0)
            ->setParameter('done', 100)
            ->getResult();
    }

    public function findAllItemsThatAreDone()
    {
        return $this->getEntityManager()->createQuery(
                'SELECT t FROM AppBundle:Todo t WHERE t.done = :done'
            )
            ->setParameter('done', 100)
            ->getResult();
    }
}
