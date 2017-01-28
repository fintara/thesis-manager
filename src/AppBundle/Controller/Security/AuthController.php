<?php

namespace AppBundle\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    public function getLoginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');

        $error = $authUtils->getLastAuthenticationError();
        $lastEmail = $authUtils->getLastUsername();



        return $this->render('@App/login/index.html.twig', [
            'error' => $error,
            'lastEmail' => $lastEmail,
        ]);
    }

    public function postLoginAction(Request $request)
    {
        throw $this->createAccessDeniedException('You must not be able to access this.');
    }
}
