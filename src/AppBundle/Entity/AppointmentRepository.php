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

    public function findDate(\DateTime $start, \DateTime $end)
    {
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
}
