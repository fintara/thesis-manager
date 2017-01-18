<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Thesis;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ThesisController extends Controller
{
    public function getChooseReviewersAction(Request $request)
    {
        return $this->render('@App/thesis_reviewers/index.html.twig');
    }

    public function ajaxGetChooseReviewersAction(Request $request)
    {
        $reviewers = $this->get('user.repository')->findByType(Worker::TYPE);
        $theses = $this->get('thesis.repository')->findByStatus(Thesis::STATUS_FINAL);

        return new JsonResponse([
            'reviewers' => [
                'count' => count($reviewers),
                'list'  => array_map(function($reviewer) {
                    return $this->get('serializer')->normalize($reviewer);
                }, $reviewers),
            ],
            'theses' => [
                'count' => count($theses),
                'list'  => array_map(function($thesis) {
                    return $this->get('serializer')->normalize($thesis);
                }, $theses),
            ],
        ]);
    }

    public function postChooseReviewersAction(Request $request)
    {
        $data = $request->get('data');

        $error = function($msg) {
            return ['message' => $msg];
        };

        if (!is_array($data)) {
            return new JsonResponse($error('Invalid data'));
        }

        foreach($data as $pair) {
            /** @var Thesis $thesis */
            $thesis = $this->get('thesis.repository')->find($pair['thesis']);

            if (!$thesis) {
                return new JsonResponse($error('No thesis #'.$pair['thesis']), 403);
            }

            /** @var User|Worker $reviewer */
            $reviewer = $this->get('user.repository')->find($pair['reviewer']);

            if (!$reviewer || $reviewer->getType() !== Worker::TYPE) {
                return new JsonResponse($error('No reviewer #'.$pair['reviewer']), 403);
            }

            $this->get('thesis.service')->assignReviewer($thesis, $thesis->getTopic()->getSupervisor());
            $this->get('thesis.service')->assignReviewer($thesis, $reviewer);
        }

        return new JsonResponse([
            'message' => 'ok'
        ]);
    }
}