<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @Route(name="user_", path="/user")
 */
class UserController extends Controller
{

    /**
     * @Route(name="signIn", path="/sign_in")
     */
    public function signInAction()
    {
        return new Response("<html><body>You're on the user sign in page, congratulations !</body></html>");
    }

    /**
     * @Route(name="signUp", path="/sign_up")
     */
    public function signUpAction()
    {
        return new Response("<html><body>You're on the user sign up page, congratulations !</body></html>");
    }

    /**
     * @Route(name="myAds", path="/my_ads")
     */
    public function myAdsAction()
    {
        return new Response("<html><body>You're on the user own ads page, congratulations !</body></html>");
    }

    /**
     * @Route(name="favorites", path="/favorites")
     */
    public function favoritesAction()
    {
        return new Response("<html><body>You're on the user favorites page, congratulations !</body></html>");
    }

    /**
     * @Route(name="default", path="/{slug}")
     */
    public function gotoDefaultAction()
    {
        return $this->redirectToRoute('user_signIn');
    }
}