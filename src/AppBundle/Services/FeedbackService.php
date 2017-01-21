<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 18/01/2017
 * Time: 22:02
 */

namespace AppBundle\Services;


use AppBundle\Entity\Draft;
use AppBundle\Entity\Feedback;
use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use AppBundle\Models\DraftModel;
use AppBundle\Models\FeedbackModel;
use AppBundle\Models\ReviewModel;
use AppBundle\Repository\DraftRepository;
use AppBundle\Repository\FeedbackRepository;
use AppBundle\Repository\ReviewRepository;
use AppBundle\Repository\ThesisRepository;

class FeedbackService
{
    /** @var FeedbackRepository  */
    private $repo;

    public function __construct(FeedbackRepository $repository)
    {
        $this->repo = $repository;
    }

    public function create(FeedbackModel $model, bool $flush = true): Feedback
    {
        $feedback = new Feedback();

        $feedback->setFile($model->file);
        $feedback->setContent($model->comment);
        $feedback->setSupervisor($model->supervisor);
        $feedback->setDraft($model->draft);
        $feedback->setCreatedAt(new \DateTime());

        if ($flush) {
            $this->repo->save($feedback);
        }

        return $feedback;
    }

}