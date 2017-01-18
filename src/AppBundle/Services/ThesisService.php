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

    public function assignReviewer(Thesis $thesis, Worker $reviewer)
    {
        $thesis->addReviewer($reviewer);
        $this->repo->save($thesis);
    }


}