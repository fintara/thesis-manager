<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TopicsController extends Controller
{
    public function getTopicsAction(Request $request)
    {
        return $this->render('@App/topics/index.html.twig');
    }

    public function ajaxGetTopicsAction(Request $request)
    {
        $topics = $this->get('topic.repository')->findByStatus(Topic::STATUS_APPROVED);

        return new JsonResponse([
            'count' => count($topics),
            'list'  => array_map(function($topic) {
                return $this->get('serializer')->normalize($topic);
            }, $topics),
        ]);
    }
}


