<?php

namespace AppBundle\Calendar\Appointment;

use Doctrine\ORM\EntityRepository;
use AppBundle\Calendar\Appointment\Appointment;

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

        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->select('a')
            ->from(Appointment::class, 'a')
            ->where('a.epoch BETWEEN ?1 AND ?2')
            ->setParameter(1, $start)
            ->setParameter(2, $end)
            ->getQuery();

        return $q->getResult();
    }

    public function findFirst(\DateTime $after)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->select('a')
            ->from(Appointment::class, 'a')
            ->where('a.epoch > ?1')
            ->setParameter(1, $after)
            ->setMaxResults(1)
            ->getQuery();

        return $q->getResult();
    }
}
