<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TopicsController extends Controller
{
    public function getTopicsAction(Request $request)
    {
        $topics = [];

        return $this->render('@App/topics/index.html.twig', [
            'topics' => $topics,
        ]);
    }
}
