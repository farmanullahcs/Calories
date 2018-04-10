<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class loginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        //$authenticationUtils = $this->get('security.authentication_utils');
        $errors = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();
        return $this->render('AppBundle:login:login.html.twig',  array(
            'error' => $errors,
            'username' => $username,
        ));

    }

    /*
     * @Route("/logout", name="logout")
     */

    public function logoutAction()
    {
        //.....
    }

}