<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Review;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ReviewRepository
 * @package AppBundle\Repository
 */
class ReviewRepository extends EntityRepository implements ReviewRepositoryInterface
{
    /** @var string */
    private $directory;

    /**
     * @inheritdoc
     */
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

    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    /**
     * Moves uploaded file to directory
     * @param Review $review
     */
    private function upload(Review $review)
    {
        $file = $review->getFile();

        $filename = md5(uniqid()).'.'.$file->guessExtension();

        $file->move(
            $this->directory,
            $filename
        );

        $review->setFilename($filename);
    }
}
