<?php
/**
 * Created by PhpStorm.
 * User: fintara
 * Date: 24/01/2017
 * Time: 14:33
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Feedback;

interface FeedbackRepositoryInterface
{
    public function save(Feedback $feedback, bool $flush = true): Feedback;
    public function setDirectory($directory);
}