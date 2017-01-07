<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    public function submitReviewAction(Request $request, Thesis $thesis)
    {
        // form ( file, description )

        // if form is submitted and valid, save the new data and redict

        // otherwise + default
        // render the form ( Resources - views )
    }
}
