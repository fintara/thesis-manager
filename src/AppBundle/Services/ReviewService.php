<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 18/01/2017
 * Time: 22:02
 */

namespace AppBundle\Services;


use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use AppBundle\Models\ReviewModel;
use AppBundle\Repository\ReviewRepository;
use AppBundle\Repository\ThesisRepository;

class ReviewService
{
    /** @var ReviewRepository  */
    private $repo;

    public function __construct(ReviewRepository $repository)
    {
        $this->repo = $repository;
    }

    public function create(ReviewModel $model, bool $flush = true): Review
    {
        $review = new Review();

        $review->setTitle($model->title);
        $review->setFile($model->file);
        $review->setGrade($model->grade);
        $review->setReviewer($model->reviewer);
        $review->setCreatedAt(new \DateTime());

        if ($flush) {
            $this->repo->save($review);
        }

        return $review;
    }

    public function assign(Review $review, Thesis $thesis): Review
    {
        $review->setThesis($thesis);
        $thesis->addReview($review);

        return $review;
    }

}