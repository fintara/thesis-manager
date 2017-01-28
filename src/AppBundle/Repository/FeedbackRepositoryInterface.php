<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:33
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Feedback;

/**
 * Interface FeedbackRepositoryInterface
 * @package AppBundle\Repository
 */
interface FeedbackRepositoryInterface
{
    /**
     * Saves and uploads a feedback.
     *
     * @param  Feedback $feedback Feedback to be saved
     * @param  bool $flush        Whether to save it to database immediately
     * @return Feedback           Saved feedback
     */
    public function save(Feedback $feedback, bool $flush = true): Feedback;

    /**
     * @param string $directory Directory where feedbacks are saved
     */
    public function setDirectory(string $directory): void;
}