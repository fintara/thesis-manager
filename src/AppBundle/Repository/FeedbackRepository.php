<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Feedback;
use Doctrine\ORM\EntityRepository;

/**
 * Class FeedbackRepository
 * @package AppBundle\Repository
 */
class FeedbackRepository extends EntityRepository implements FeedbackRepositoryInterface
{
    /** @var string */
    private $directory;

    public function save(Feedback $feedback, bool $flush = true): Feedback
    {
        if ($feedback->getFile() !== null) {
            $this->upload($feedback);
        }

        $this->getEntityManager()->persist($feedback);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $feedback;
    }

    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    /**
     * Moves the uploaded file to directory.
     * @param Feedback $feedback
     */
    private function upload(Feedback &$feedback)
    {
        $file = $feedback->getFile();

        $filename = md5(uniqid()).'.'.$file->guessExtension();

        $file->move(
            $this->directory,
            $filename
        );

        $feedback->setFilename($filename);
    }
}
