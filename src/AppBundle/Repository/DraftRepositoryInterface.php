<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:34
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Draft;
use AppBundle\Entity\Thesis;

interface DraftRepositoryInterface
{
    public function findLastVersion(Thesis $thesis): int;
    public function findNewest(Thesis $thesis);
    public function save(Draft $draft, bool $flush = true): Draft;
    public function setDirectory($directory);
}