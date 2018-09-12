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

//    /**
//     * @Route(name="localIndex", path="/index")
//     */
//    public function showIndexAction(Request $request)
//    {
//        $locale = $request->getLocale();
//        return $this->redirectToRoute('home_localIndex');
//    }

    /**
     * @Route(name="showIndex", path="/{_locale}/index")
     */
    public function showIndexAction(Request $request)
    {
        $locale = $request->getLocale();
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route(name="gotoIndex", path="/{slug}")
     */
    public function gotoIndexAction()
    {
        return $this->redirectToRoute('home_showIndex');
    }
}