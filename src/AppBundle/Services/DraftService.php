<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 18/01/2017
 * Time: 22:02
 */

namespace AppBundle\Services;


use AppBundle\Entity\Draft;
use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use AppBundle\Models\DraftModel;
use AppBundle\Models\ReviewModel;
use AppBundle\Repository\DraftRepository;
use AppBundle\Repository\ReviewRepository;
use AppBundle\Repository\ThesisRepository;

class DraftService
{
    /** @var DraftRepository  */
    private $repo;

    public function __construct(DraftRepository $repository)
    {
        $this->repo = $repository;
    }

    public function create(DraftModel $model, bool $flush = true): Draft
    {
        $draft = new Draft();

        $draft->setFile($model->file);
        $draft->setComment($model->comment);
        $draft->setStudent($model->student);
        $draft->setThesis($model->thesis);
        $draft->setVersion($this->repo->findLastVersion($model->thesis) + 1);
        $draft->setCreatedAt(new \DateTime());

        if ($flush) {
            $this->repo->save($draft);
        }

        return $draft;
    }

}