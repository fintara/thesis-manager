<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:07
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;

/**
 * Interface ThesisRepositoryInterface
 *
 * @package AppBundle\Repository
 */
interface ThesisRepositoryInterface
{
    /**
     * Returns a list of theses with less than 2 reviewers.
     *
     * @return Thesis[]
     */
    public function findToBeReviewed(): array;

    /**
     * Returns a list of theses containing worker as a reviewer.
     *
     * @param Worker $worker
     * @return Thesis[]
     */
    public function findAllToReviewBy(Worker $worker): array;

    /**
     * Returns a list of theses supervised by worker.
     *
     * @param Worker $worker
     * @return Thesis[]
     */
    public function findAllSupervisedBy(Worker $worker): array;

    /**
     * Saves a thesis.
     *
     * @param Thesis $thesis    Thesis to be saved
     * @param bool $flush       Whether to immediately save to database
     * @return Thesis           Saved thesis
     */
    public function save(Thesis $thesis, bool $flush = true): Thesis;
}