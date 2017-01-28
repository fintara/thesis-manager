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

//            $this->addFlash('success', 'Review was submitted successfully');

            return $this->redirect(
                $this->generateUrl('app_thesis_get', ['thesis' => $thesis->getId()])
                .'?review_added=1'
            );
        }

        return $this->render('@App/thesis/review/submit.html.twig', [
            'thesis' => $thesis,
            'form'   => $form->createView(),
        ]);
    }

    public function getChooseReviewersAction(Request $request)
    {
        return $this->render('@App/thesis/reviewers/index.html.twig');
    }

    public function ajaxGetChooseReviewersAction(Request $request)
    {
        $thesisId = $request->query->getInt('thesis_id', 0);

        $reviewers  = $this->get('user.repository')->findByType(Worker::TYPE);

        if ($thesisId > 0) {
            /** @var Thesis[] $theses */
            $theses = [$this->get('thesis.repository')->findOneById($thesisId)];
            foreach ($reviewers as $key => $reviewer) {
                if ($theses[0]->getReviewers()->contains($reviewer)) {
                    unset ($reviewers[$key]);
                }
            }
            $reviewers = array_values($reviewers);
        } else {
            $theses     = $this->get('thesis.repository')->findToBeReviewed();
        }

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
                $badIds[] = $id;
                continue;
            }

            /** @var User|Worker $reviewer */
            $reviewer = $this->get('user.repository')->find($pair['reviewer']);

            if (!$reviewer || $reviewer->getType() !== Worker::TYPE) {
                $badIds[] = $id;
                continue;
            }


            try {
                if (!$thesis->getReviewers()->contains($thesis->getSupervisor())) {
                    $this->get('thesis.service')->assignReviewer($thesis, $thesis->getSupervisor(), false);
                }
                $this->get('thesis.service')->assignReviewer($thesis, $reviewer, false);
                $thesis->setStatus(Thesis::STATUS_REVIEWING);
                $this->get('thesis.repository')->save($thesis);
                $savedIds[] = $id;
            } catch (\Exception $e) {
                $badIds[] = $id;
            }
        }

        return new JsonResponse([
            'message'   => count($badIds) === 0 ? 'ok' : 'semi',
            'savedIds'  => $savedIds,
            'badIds'    => $badIds,
        ]);
    }
}