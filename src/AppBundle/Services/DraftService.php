<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 18/01/2017
 * Time: 22:02
 */

namespace AppBundle\Services;


use AppBundle\Entity\Draft;
use AppBundle\Models\DraftModel;
use AppBundle\Repository\DraftRepository;
use AppBundle\Repository\DraftRepositoryInterface;

/**
 * Draft service
 *
 * @package AppBundle\Services
 */
class DraftService
{
    /** @var DraftRepository */
    private $repo;

    /**
     * DraftService constructor.
     * @param DraftRepositoryInterface $repository Repository for Draft
     */
    public function __construct(DraftRepositoryInterface $repository)
    {
        $this->repo = $repository;
    }

    /**
     * Creates and saves Draft from DraftModel
     *
     * @param  DraftModel $model    Initial data
     * @param  bool $flush          Whether to immediately save to database
     * @return Draft                Transformed Draft
     */
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