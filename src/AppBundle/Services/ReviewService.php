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
use AppBundle\Models\ReviewModel;
use AppBundle\Repository\ReviewRepositoryInterface;

/**
 * Review service
 *
 * @package AppBundle\Services
 */
class ReviewService
{
    /** @var ReviewRepositoryInterface  */
    private $repo;

    /**
     * ReviewService constructor.
     *
     * @param ReviewRepositoryInterface $repository Repository for Review
     */
    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->repo = $repository;
    }

    /**
     * Creates and saves Review from ReviewModel.
     *
     * @param ReviewModel $model    Initial data
     * @param bool $flush           Whether to immediately save to database
     * @return Review               Transformed Review
     */
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

    /**
     * Assigns review to a thesis.
     *
     * @param Review $review    Review to be assigned
     * @param Thesis $thesis    Thesis to which review is assigned
     * @return Review           Assigned review
     */
    public function assign(Review $review, Thesis $thesis): Review
    {
        $review->setThesis($thesis);
        $thesis->addReview($review);

        return $review;
    }

}