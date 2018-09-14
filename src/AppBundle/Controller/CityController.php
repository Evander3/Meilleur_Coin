<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Country;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route(name="city_", path="/{_locale}/city")
 */
class CityController extends Controller
{
    /**
     * @Route(name="addCities", path="/add-cities")
     */
    public function addCitiesAction()
    {
        $country = $this
            ->getDoctrine()
            ->getRepository(Country::class)
            ->find(5)
        ;
        $entitymanager = $this
            ->getDoctrine()
            ->getManager()
        ;

        $ville1 = new City();
        $ville1->setName('Ville 1');
        $ville1->setPopulation(57681);

        $country->addCity($ville1);

        $entitymanager->persist($country);
        $entitymanager->flush();

    }

    /**
     * @Route(name="new", path="/new")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        /// ici on a tout mis dans le controller : pas bien.
        ///
        /// la construction du formulaire (donc formBuilder) doit etre en
        /// fait envoyée dans une classs form héritant de abstract form.
        ///
        /// De meme les contraintes peuvent etre déplacées au niveau de
        ///  l'entité directement.
        $city = new City();

        $form = $this
            ->createFormBuilder($city)
            ->add('name', TextType::class, [
                'constraints'=>new Length(['max'=>10])
            ])
            ->add('population', IntegerType::class, [
                'constraints'=>new Type(['type'=>'integer'])
            ])
            ->add('country', EntityType::class, [
                'class'=>Country::class,
                'choice_label'=>'name',
                'placeholder'=>' -- Choisir Pays -- ',
            ])
            ->add('terms', CheckboxType::class, [
                'label'=>"J'accepte que ma ville soit sauvegarder",
                // on peut avoir besoin de champ on-the-fly dans le formulaire
                // qui ne servent qu'à la validation du formulaire et de ne pas
                // garder ces données en base
                'mapped'=>false,
                'required'=>false,
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted()
            && $form->isValid()
            && $form->get('terms')->getData()
        )
        {
            dump($form->getData());
            $entitymanager = $this
                ->getDoctrine()
                ->getManager()
            ;
            $entitymanager->persist($city);
            $entitymanager->flush();
        }

        dump($city);

        return $this->render('city/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

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
//        return new Response('<html><body>Remove : '.$id.'</body></html>');
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
    public function listAction(
        RouterInterface $router
    )
    {
        // grâce à la méthode generateUrl on est en mesure de générer à la volée
        // une url vers une autre route en lui passant un tableau si besoin est.
//        $url = $this->generateUrl('city_remove', ['id'=>8]);

        // Si on hérite pas de Controller, on va pouvoir faire la même chose
        // grâce au service Router
        $url = $router->generate('city_remove', ['id'=>9]);
//        return new Response('List cities <a href="'.$url.'">Supprimer !</a>');

        dump($url);



        $cities = $this
            ->getDoctrine()
            ->getRepository(City::class)
            ->findAll()
        ;


        $cityRouter = $this->container->get('AppBundle\Router\CityRouter');

        // on créé le QueryBuilder à partir de l'entitymanager
        $queryBuilder = $this
            ->getDoctrine()
            ->getManager()
            ->createQueryBuilder('c')
        ;

        // de facon chainée, on va venir créer notre Query
        // ensuite, on récupère notre Query
        $query = $queryBuilder
            ->select('c')
            ->from('AppBundle:City', 'c')
            ->where('c.population >= :population')
            ->where($queryBuilder->expr()->orX(
                $queryBuilder->expr()->gte('c.population', ':population'),
                $queryBuilder->expr()->like('c.name', ':name')
            ))
            ->setParameter('population', 100000)
            ->setParameter('name', '%nn%')
            ->getQuery()
        ;

        // une fois que l'on a notre query, on va etre capable de récupérer les résultats
        $cities = $query->getResult();

        // Maintenant on va fiare la meme chose mais avec du DQL
        // (Doctrine Query Langage)
        $dql = <<<DQL
SELECT c
FROM AppBundle:City c
WHERE c.population >= :population OR c.name LIKE :name
DQL;

        // C'est une autre façon de récupérer mes villes
        // plus simple et plus lisible
        $city = $this
            ->getDoctrine()
            ->getManager()
            ->createQuery($dql)
            ->setParameter('population', 100000)
            ->setParameter('name', '%nn%')
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;

        // En déplacant la query dans le repo, on peut la réutiliser
        // sans avoir à la réécrire.
        $cities = $this
            ->getDoctrine()
            ->getRepository(City::class)
            ->findCitiesWithPopulationGreaterThan100000()
        ;

        dump($city->getName());

        return $this->render('city/list.html.twig',
            ['cities'=> $cities]
        );
    }

    /**
     * @Route(name="load", path="/load")
     */
    public function loadAction()
    {
        $cities = [
          ['Nantes', 200000],
          ['Rennes', 160000],
          ['La Roche sur Yon', 60000],
          ['Angers', 80000],
        ];

        $entitymanager = $this
            ->getDoctrine()
            ->getManager()
        ;

        $belgique = $this
            ->getDoctrine()
            ->getRepository(Country::class)
            ->find(5)
        ;

        foreach ($cities as $data)
        {
            $city = new City();
            $city->setName($data[0]);
            $city->setPopulation($data[1]);
            $city->setCountry($belgique);

            //ici on fait un petit persist mais surtout pas de flush
            $entitymanager->persist($city);
        }
        //le flush doit etre après la boucle
        $entitymanager->flush();

        return new Response('<html><body>yop yop</body></html>');
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