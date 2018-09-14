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
     * @Route(name="gotoIndex", path="/")
     * @Route(name="index", path="/index")
     */
    public function gotoIndexAction(Request $request)
    {
        $locale = $request->getLocale();
        return $this->redirectToRoute('home_showIndex');
    }

    /**
     * @Route(name="showIndex", path="/{_locale}/index", requirements={"_locale" = "fr|en"})
     */
    public function showIndexAction()
    {
        return $this->render('index/index.html.twig');
    }
}