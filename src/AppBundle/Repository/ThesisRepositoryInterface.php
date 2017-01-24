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

interface ThesisRepositoryInterface
{
    public function findAllToReviewBy(Worker $worker): array;
    public function findAllSupervisedBy(Worker $worker): array;
    public function save(Thesis $thesis, bool $flush = true): Thesis;
}