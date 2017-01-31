<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use Doctrine\ORM\EntityRepository;

/**
 * Class ThesisRepository
 *
 * @package AppBundle\Repository
 */
class ThesisRepository extends EntityRepository implements ThesisRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function save(Thesis $thesis, bool $flush = true): Thesis
    {
        $this->getEntityManager()->persist($thesis);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $thesis;
    }

    /**
     * {@inheritdoc}
     */
    public function findToBeReviewed(): array
    {
        /** @var Thesis[] $theses */
        $theses = $this->findByStatus(Thesis::STATUS_FINAL);

        foreach ($theses as $key => $thesis) {
            if ($thesis->getReviewers()->count() >= 2) {
                unset ($theses[$key]);
            }
        }

        return array_values($theses);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllToReviewBy(Worker $worker): array
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT th, t, s 
FROM AppBundle:Thesis th
INNER JOIN th.topic t 
INNER JOIN t.supervisor sv
INNER JOIN th.reviewers r
INNER JOIN th.students s
WHERE r = :worker'
            );

        $query->setParameter('worker', $worker);

        /** @var Thesis[] $theses */
        $theses = $query->getResult();
        $theses = array_filter($theses, function($t) use ($worker) {
            /** @var Thesis $t */
            return !$t->getReviews()->map(function($r) {
                /** @var Review $r */
                return $r->getReviewer();
            })->contains($worker);
        });

        return $theses;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllSupervisedBy(Worker $worker): array
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT th, t, s 
FROM AppBundle:Thesis th
INNER JOIN th.topic t 
INNER JOIN t.supervisor sv
LEFT JOIN th.reviewers r
INNER JOIN th.students s
WHERE sv = :worker'
            );

        $query->setParameter('worker', $worker);

        return $query->getResult();
    }
}
