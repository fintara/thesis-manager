<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Thesis;

/**
 * Interface TopicRepositoryInterface
 *
 * @package AppBundle\Repository
 */
interface TopicRepositoryInterface
{
    /**
     * Finds a thesis by id and status.
     *
     * @param   int $id         ID of thesis
     * @param   string $status  Status of thesis
     * @return  Thesis|null
     * @throws \Exception Thrown if status is invalid
     */
    public function findByIdAndStatus(int $id, string $status): ?Thesis;

    /**
     * Returns a list of theses with provided status.
     *
     * @param string $status
     * @return Thesis[]
     * @throws \Exception Thrown if status is invalid
     */
    public function findByStatus(string $status): array;
}