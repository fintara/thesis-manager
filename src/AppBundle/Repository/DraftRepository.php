<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Draft;
use AppBundle\Entity\Thesis;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * DraftRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DraftRepository extends EntityRepository
{
    private $directory;

    /**
     * Description what this method does
     * @param Thesis $thesis Last version of the drafts for this thesis
     * @return int Version number of the last draft or 0, if no drafts
     */
    public function findLastVersion(Thesis $thesis): int
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT d.version
FROM AppBundle:Draft d
WHERE d.thesis = :thesis
ORDER BY d.version DESC'
            );

        $query->setParameter('thesis', $thesis);

        $query->setMaxResults(1);

        try {
            return $query->getSingleScalarResult();
        } catch (NoResultException $e) {
            return 0;
        }
    }

    public function findNewest(Thesis $thesis)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT d
FROM AppBundle:Draft d
WHERE d.thesis = :thesis
ORDER BY d.version DESC'
            );

        $query->setParameter('thesis', $thesis);

        return $query->getResult();
    }

    public function save(Draft $draft, bool $flush = true): Draft
    {
        if ($draft->getFile() !== null) {
            $this->upload($draft);
        }

        $this->getEntityManager()->persist($draft);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $draft;
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    private function upload(Draft &$draft)
    {
        $file = $draft->getFile();

        $filename = md5(uniqid()).'.'.$file->guessExtension();

        $file->move(
            $this->directory,
            $filename
        );

        $draft->setFilename($filename);
    }
}
