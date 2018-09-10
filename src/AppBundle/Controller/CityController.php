<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\City;

/**
 * @Route(name="city_", path="/city")
 */
class CityController extends Controller
{
    /**
     * Je restreins cette route grâce à une regex dans requirements
     * (ici un nombre "d+")
     *
     * @Route(name="remove", path="/{id}", requirements={"id"="\d+"})
     */
    public function removeAction($id)
    {
        // La méthode redirectToRoute  permet de faire une redirection 302 vers une autre url
        return $this->redirectToRoute('city_list');
        return new Response('<html><body>Remove : '.$id.'</body></html>');
    }

    /**
     * J'ai fais le choix sur cette route, de définir un slash à la fin de l'rul
     * Si j'appelle /city/build, j'ai une redirection 301 vers /city/build/
     *
     * @Route(name="build", path="/build/")
     */
    public function buildAction()
    {
        return new Response("<html><body>Build !</body></html>");
    }

    /**
     * @Route(name="destroy", path="/destroy")
     */
    public function destroyAction()
    {
        return new Response('<html><body>Destroy !</body></html>');
    }

    /**
     * L'ordre des routes est important, si /list est après get
     * Le système va traiter list comme un slug
     *
     * @Route(name="list", path="/list")
     */
    public function listAction()
    {
        // grâce à la méthode generateUrl on est en mesure de générer à la volée
        // une url vers une autre route en lui passant un tableau si besoin est.
        $url = $this->generateUrl('city_remove', ['id'=>8]);

        // Si on hérite pas de Controller, on va pouvoir faire la même chose
        // grâce au service Router
//        $url = $route->generate('city_remove', ['id'=>9]);
        return new Response('List cities <a href="'.$url.'">Supprimer !</a>');
    }

    /**
     * @Route(name="get", path="/{slug}")
     */
    public function getAction(Request $request, $slug)
    {
        // Si je tente de trouver $slug et ca n'existe pas :
//        throw $this->createNotFoundException("Exception : $slug");
//
//        // Si jamais il y a un gros pépin
//        throw new Exception("Error 500 : $slug");
//        return new Response('Get : '.$slug);

        // Si mon URL contient ?var=1 :
//        dump($request->get('var'));

        $request->getSession()->set('var',4);
        return new Response('<html><body>Get : '.$slug.'</body></html>');
    }
}