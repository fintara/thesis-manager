<?php

namespace AppBundle\Controller\Theses;

use AppBundle\Entity\Review;
use AppBundle\Entity\Thesis;
use AppBundle\Entity\User;
use AppBundle\Entity\Worker;
use AppBundle\Models\DraftModel;
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

        return $this->render('@App/thesis_drafts/index.html.twig', [
            'thesis' => $thesis,
            'drafts' => $drafts,
        ]);
    }

    public function getNewDraftAction(Request $request, Thesis $thesis)
    {
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
}