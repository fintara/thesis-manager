<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 18/01/2017
 * Time: 22:02
 */

namespace AppBundle\Services;


use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use AppBundle\Repository\ThesisRepositoryInterface;

class ThesisService
{
    /** @var ThesisRepositoryInterface  */
    private $repo;

    public function __construct(ThesisRepositoryInterface $repository)
    {
        $this->repo = $repository;
    }

    public function assignReviewer(Thesis $thesis, Worker $reviewer, bool $flush = true)
    {
        if ($thesis->getReviewers()->contains($reviewer)) {
            throw new \Exception('Reviewer already assigned');
        }

        $thesis->addReviewer($reviewer);

        if ($flush) {
            $this->repo->save($thesis);
        }
    }


}