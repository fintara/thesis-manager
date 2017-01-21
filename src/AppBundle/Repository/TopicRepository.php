<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Topic;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class TopicRepository extends EntityRepository
{
    public function findByIdAndStatus(int $id, string $status)
    {
        if (!in_array($status, Topic::getStatuses(), true)) {
            throw new \Exception('Invalid status "'.$status.'"');
        }

        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT t, s, r 
FROM AppBundle:Topic t 
INNER JOIN t.supervisor s 
LEFT JOIN t.reservations r
WHERE t.id = :id AND t.status = :status'
            );

        $query->setParameter('id', $id);
        $query->setParameter('status', $status);

        return $query->getSingleResult(AbstractQuery::HYDRATE_OBJECT);
    }

    public function findByStatus(string $status)
    {
        if (!in_array($status, Topic::getStatuses(), true)) {
            throw new \Exception('Invalid status "'.$status.'"');
        }

        return $this->getEntityManager()
            ->createQuery(
                'SELECT t, s, r 
FROM AppBundle:Topic t 
INNER JOIN t.supervisor s 
LEFT JOIN t.reservations r
ORDER BY s.firstName + s.lastName ASC'
            )
            ->getResult();
    }
}
