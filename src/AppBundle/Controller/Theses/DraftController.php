<?php

namespace AppBundle\Controller\Theses;

use AppBundle\Entity\Draft;
use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use AppBundle\Models\DraftModel;
use AppBundle\Models\FeedbackModel;
use AppBundle\Models\ReviewModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DraftController extends Controller
{
    public function getDraftsAction(Request $request, Thesis $thesis)
    {
        $drafts = $this->get('draft.repository')->findNewest($thesis);
        /** @var Draft|null $lastDraft */
        $lastDraft = $thesis->getDrafts()->last();

        $nextUpload = null;

        if ($this->isGranted('ROLE_STUDENT') && $lastDraft && !$this->getUser()->canUploadDraft($thesis)) {
//            $diff = $lastDraft->getCreatedAt()->diff(new \DateTime());
            $nextUpload = $lastDraft->getCreatedAt();
            $nextUpload->modify('+ 1 day');
        }

        return $this->render('@App/thesis_drafts/index.html.twig', [
            'thesis' => $thesis,
            'drafts' => $drafts,
            'nextUpload' => $nextUpload,
        ]);
    }

    public function getNewDraftAction(Request $request, Thesis $thesis)
    {
        if (!$this->getUser()->canUploadDraft($thesis)) {
            throw $this->createAccessDeniedException();
        }

        $model = new DraftModel();
        $model->thesis = $thesis;
        $model->student = $this->getUser();

        /** @var Form $form */
        $form = $this->createFormBuilder($model)
            ->add('comment', TextareaType::class)
            ->add('file', FileType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $draft = $this->get('draft.service')->create($model);

            $this->addFlash('success', 'Draft was uploaded successfully');

            return $this->redirectToRoute('app_thesis_drafts_get', ['thesis' => $thesis->getId()]);
        }

        return $this->render('@App/thesis_drafts/submit.html.twig', [
            'thesis' => $thesis,
            'form'   => $form->createView(),
        ]);
    }

    public function getNewFeedbackAction(Request $request, Thesis $thesis, Draft $draft)
    {
        if ($draft->getThesis() != $thesis) {
            throw $this->createAccessDeniedException();
        } elseif ($this->isGranted('ROLE_TEACHER') && $thesis->getSupervisor() != $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $model = new FeedbackModel();
        $model->draft = $draft;
        $model->supervisor = $this->getUser();

        /** @var Form $form */
        $form = $this->createFormBuilder($model)
            ->add('comment', TextareaType::class)
            ->add('file', FileType::class, [
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedback = $this->get('feedback.service')->create($model);

            $this->addFlash('success', 'Feedback was added successfully');

            return $this->redirectToRoute('app_thesis_drafts_get', ['thesis' => $thesis->getId()]);
        }

        return $this->render('@App/thesis_drafts/submit_feedback.html.twig', [
            'thesis' => $thesis,
            'draft'  => $draft,
            'form'   => $form->createView(),
        ]);
    }
}