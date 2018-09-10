<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @Route(name="home_", path="/")
 */
class HomeController extends Controller
{

    /**
     * @Route(name="index", path="/index")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}