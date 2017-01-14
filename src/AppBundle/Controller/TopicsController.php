<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TopicsController extends Controller
{
    public function getTopicsAction(Request $request)
    {
        $topics = $this->get('topic.repository')->findByStatus(Topic::STATUS_APPROVED);

        return $this->render('@App/topics/index.html.twig', [
            'topics' => $topics,
        ]);
    }
}
