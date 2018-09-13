<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @Route(name="home_", path="")
 */
class HomeController extends Controller
{

    /**
     * @Route(name="faq", path="/faq")
     */
    public function faqAction()
    {
        return new Response("<html><body>You're on the FAQ page, congratulations !</body></html>");
    }

    /**
     * @Route(name="cgu", path="/cgu")
     */
    public function cguAction()
    {
        return new Response("<html><body>You're on the CGU page, congratulations !</body></html>");
    }

    /**
     * @Route(name="showIndex", path="/index")
     */
    public function showIndexAction()
    {
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route(name="gotoIndex", path="/")
     */
    public function gotoIndexAction()
    {
        return $this->redirectToRoute('home_showIndex');
    }
}