<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TodoRepository extends EntityRepository
{
    public function findAllItemsThatAreNotDone()
    {
        return $this->getEntityManager()->createQuery(
                'SELECT t FROM AppBundle:Todo t WHERE t.done = :done'
            )
            ->setParameter('done', false)
            ->getResult();
    }

    public function findAllItemsThatAreDone()
    {
        return $this->getEntityManager()->createQuery(
                'SELECT t FROM AppBundle:Todo t WHERE t.done = :done'
            )
            ->setParameter('done', true)
            ->getResult();
    }
}
