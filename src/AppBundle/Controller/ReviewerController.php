<?php

namespace AppBundle\Controller;

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
    public function ajaxGetTopicsAction(Request $request)
    {
        $reviewer = $this->get('worker.repository')->findByStatus(Worker::STATUS_APPROVED);

        return new JsonResponse([
            'count' => count($reviewer),
            'list'  => array_map(function($reviewer) {
                return $this->get('serializer')->normalize($reviewer);
            }, $reviewer),
        ]);
    }
}