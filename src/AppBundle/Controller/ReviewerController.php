<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Thesis;
use AppBundle\Entity\Worker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReviewerController extends Controller
{
    public function getReviewerAction(Request $request)
    {
        return $this->render('@App/reviewers/index.html.twig');
    }
    public function ajaxGetReviewersAction(Request $request)
    {
        $reviewers = $this->get('user.repository')->findByType(Worker::TYPE);
        $theses = $this->get('thesis.repository')->findByStatus(Thesis::STATUS_FINAL);

        return new JsonResponse([
            'reviewers' => [
            'count' => count($reviewers),
            'list'  => array_map(function($reviewer) {
                return $this->get('serializer')->normalize($reviewer);
            }, $reviewers)],
            'theses' => [
                'count' => count($theses),
                'list'  => array_map(function($thesis) {
                    return $this->get('serializer')->normalize($thesis);
                }, $theses)]
            ]);
    }
}