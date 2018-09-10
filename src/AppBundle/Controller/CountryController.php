<?php

namespace AppBundle\Controller;

use AppBundle\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Country;

/**
 * @Route(name="country_", path="/country")
 */
class CountryController extends Controller
{
    /**
     * @Route(name="add", path="/add/{countryName}")
     */
    public function addAction($countryName)
    {
        $entitymanager = $this->getDoctrine()->getManager();

        $country = new Country();
        $country->setName($countryName);

        // Lors de la création d'un nouvel objet, je dois venir le persister
        // pour que les données soient envoyées lors du flush
        $entitymanager->persist($country);

        // Ensuite, pour le sauvegarder en BDD, je dois faire un flush
        $entitymanager->flush();

        return new Response("Added the country $countryName");
    }

    /**
     * @Route(name="edit", path="/edit")
     */
    public function editAction()
    {
        // get the data from the DB
        $countryRepository = $this
            ->getDoctrine()
            ->getRepository(Country::class)
        ;

        // dump all the table entries which 'France' as name in an array
        dump($countryRepository->findBy([
            'name'=>'France',
            ]

        ));

        // return one entry as a simpler array
        dump($countryRepository->findOneBy([
                'name'=>'France',
            ]

        ));

        $france = $countryRepository->findOneBy([
                'name'=>'France',
            ]

        );
        dump($france);
        $france->setName('Pays France');

        // J'ai pas besoin de faire un persist car c'est une maj
//        Par contre, j'ai besoin de faire un flush pour executer
//        le SQL en BDD'
        $this
            ->getDoctrine()
            ->getManager()
            ->flush()
        ;


        return new Response('<html><body><h1>yep yep yop</h1></body></html>');

    }

    /**
     * @Route(name="remove", path="/remove/{id}")
     */
    public function removeAction($id)
    {
        $country = $this
            ->getDoctrine()
            ->getRepository(Country::class)
            ->find($id)
        ;

        // on check avant que $country
        if (!$country instanceof Country) {
            throw $this->createNotFoundException();
        }

        // on supprime $country du registre
        $this
            ->getDoctrine()
            ->getManager()
            ->remove($country);
        ;

        // on finit par un flush pour impacter la BDD
        $this
            ->getDoctrine()
            ->getManager()
            ->flush();
        ;

        return new Response('<html><body><h1>yep yep yop</h1></body></html>');

    }

}