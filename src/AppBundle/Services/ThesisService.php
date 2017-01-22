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
use AppBundle\Repository\ThesisRepository;

class ThesisService
{
    /** @var ThesisRepository  */
    private $repo;

    public function __construct(ThesisRepository $repository)
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