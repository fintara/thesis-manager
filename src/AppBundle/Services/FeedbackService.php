<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 18/01/2017
 * Time: 22:02
 */

namespace AppBundle\Services;

use AppBundle\Entity\Feedback;
use AppBundle\Models\FeedbackModel;
use AppBundle\Repository\FeedbackRepository;
use AppBundle\Repository\FeedbackRepositoryInterface;


class FeedbackService
{
    /** @var FeedbackRepository  */
    private $repo;

    public function __construct(FeedbackRepositoryInterface $repository)
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