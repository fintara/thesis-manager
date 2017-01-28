<?php

namespace AppBundle\Controller\Thesis;

use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use AppBundle\Models\ReviewModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ThesisController extends Controller
{
    public function getThesesAction(Request $request, string $type)
    {
        if ($type === null || $type === 'all') {
            $theses = $this->get('thesis.repository')->findAll();
        } elseif ($type === 'to-review') {
            $theses = $this->get('thesis.repository')->findAllToReviewBy($this->getUser());
        } elseif ($type === 'supervised') {
            $theses = $this->get('thesis.repository')->findAllSupervisedBy($this->getUser());
        } else {
            $theses = [];
        }

        return $this->render('@App/thesis/index.html.twig', [
            'theses' => $theses,
        ]);
    }

    public function getThesisAction(Request $request, Thesis $thesis)
    {
        return $this->render('@App/thesis/details.html.twig', [
            'thesis' => $thesis,
        ]);
    }
}