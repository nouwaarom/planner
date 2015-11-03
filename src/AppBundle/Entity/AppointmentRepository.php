<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AppointmentRepository extends EntityRepository
{
    public function findAllAndOrderByDate()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.epoch')
            ->getQuery()
            ->getResult();
    }

    public function findDate(\DateTime $start)
    {
        $end = clone $start;
        $end->modify("+1 day");

        return $this->getEntityManager()->createQuery(
            'SELECT a
            FROM AppBundle:Appointment a
            WHERE a.epoch BETWEEN :start
            AND :end
            ORDER BY a.epoch ASC'
        )->setParameter('start', $start)
        ->setParameter('end', $end)
        ->getResult();
    }

    public function findFirst(\DateTime $after)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT a
            FROM AppBundle:Appointment a
            WHERE a.epoch > :after'
        )->setParameter('after', $after)
        ->setMaxResults(1)
        ->getOneOrNullResult();
    }
}
