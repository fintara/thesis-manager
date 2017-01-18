<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Review;
use Doctrine\ORM\EntityRepository;

/**
 * ReviewRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReviewRepository extends EntityRepository
{
    public function save(Review $review, bool $flush = true): Review
    {
        if ($review->getFile() !== null) {
            $this->upload($review);
        }

        $this->getEntityManager()->persist($review);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $review;
    }

    private function upload(Review $review)
    {
        $file = $review->getFile();
    }
}
