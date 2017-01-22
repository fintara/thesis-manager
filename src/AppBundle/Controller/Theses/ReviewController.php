<?php

namespace AppBundle\Controller\Theses;

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

class ReviewController extends Controller
{
    public function newReviewAction(Request $request, Thesis $thesis)
    {
        $model = new ReviewModel();
        $model->reviewer = $this->getUser();

        $errors = [];

        /** @var Form $form */
        $form = $this->createFormBuilder($model)
            ->add('title', TextType::class)
            ->add('file', FileType::class)
            ->add('grade', ChoiceType::class, [
                'choices' => [
                    '2.0' => 2.0,
                    '3.0' => 3.0,
                    '3.5' => 3.5,
                    '4.0' => 4.0,
                    '4.5' => 4.5,
                    '5.0' => 5.0,
                    '5.5' => 5.5,
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review = $this->get('review.service')->create($model, false);
            $review = $this->get('review.service')->assign($review, $thesis);
            $this->get('review.repository')->save($review);

            $this->addFlash('success', 'Review was submitted successfully');

            return $this->redirectToRoute('app_thesis_get', ['thesis' => $thesis->getId()]);
        }

        return $this->render('@App/thesis_review/submit.html.twig', [
            'thesis' => $thesis,
            'form'   => $form->createView(),
        ]);
    }

    public function getChooseReviewersAction(Request $request)
    {
        return $this->render('@App/thesis_reviewers/index.html.twig');
    }

    public function ajaxGetChooseReviewersAction(Request $request)
    {
        $reviewers  = $this->get('user.repository')->findByType(Worker::TYPE);
        $theses     = $this->get('thesis.repository')->findByStatus(Thesis::STATUS_FINAL);

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
        $savedIds   = [];
        $badIds     = [];

        $error = function($msg) {
            return ['message' => $msg];
        };

        if (!is_array($data)) {
            return new JsonResponse($error('Invalid data'));
        }

        foreach($data as $pair) {
            $id = (int) $pair['thesis'];

            /** @var Thesis $thesis */
            $thesis = $this->get('thesis.repository')->find($id);

            if (!$thesis) {
                return new JsonResponse($error('No thesis #'.$id), 403);
            }

            /** @var User|Worker $reviewer */
            $reviewer = $this->get('user.repository')->find($pair['reviewer']);

            if (!$reviewer || $reviewer->getType() !== Worker::TYPE) {
                return new JsonResponse($error('No reviewer #'.$pair['reviewer']), 403);
            }


            try {
                $this->get('thesis.service')->assignReviewer($thesis, $thesis->getSupervisor(), false);
                $this->get('thesis.service')->assignReviewer($thesis, $reviewer, false);
                $thesis->setStatus(Thesis::STATUS_REVIEWING);
                $this->get('thesis.repository')->save($thesis);
                $savedIds[] = $id;
            } catch (\Exception $e) {
                $badIds[] = $id;
            }
        }

        return new JsonResponse([
            'message' => count($badIds) === 0 ? 'ok' : 'semi',
            'savedIds'  => $savedIds,
            'badIds'  => $badIds,
        ]);
    }
}