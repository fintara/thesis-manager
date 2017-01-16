<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Topic;
use Doctrine\ORM\EntityRepository;

class TopicRepository extends EntityRepository
{
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
