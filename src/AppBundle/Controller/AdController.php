<?php

namespace AppBundle\Controller;

use AppBundle\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use AppBundle\Entity\Ad;
use AppBundle\Form\AdType;
use DateTime;

/**
 * @Route(name="ad_", path="/ad")
 */
class AdController extends Controller
{
    /**
     * @Route(name="new", path="/new")
     */
    public function newAction(Request $request)
    {
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entitymanager = $this
                ->getDoctrine()
                ->getManager()
            ;
            if ($ad->getDatecreated() === null) {
                $ad->setDatecreated(new DateTime());
            }
            $entitymanager->persist($ad);
            $entitymanager->flush();
        }

        return $this->render('country/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route(name="edit", path="/edit/{id}")
     */
    public function editAction($id)
    {
        // get the data
        $adRepository = $this
            ->getDoctrine()
            ->getRepository(Ad::class)
        ;

        $extracted = $adRepository->findOneBy([
            'id'=>$id,
        ]);
        dump($extracted);


        //edit :
        $extracted->setTitle(ucfirst(strtolower(str_replace(' ','_',trim($extracted->getTitle())))));
        $this
            ->getDoctrine()
            ->getManager()
            ->flush()
        ;

        return new Response('<html><body><h1>Edit of \''.$extracted->getTitle().'\' done</h1></body></html>');

    }

    /**
     * @Route(name="list", path="/list")
     */
    public function listAction()
    {
        $ads = $this
            ->getDoctrine()
            ->getRepository(Ad::class)
            ->findAdsCostlyPoneys()
        ;

        return $this->render('ad/list.html.twig',
            ['ads'=> $ads]
        );
    }

    /**
     * @Route(name="search", path="/search")
     */
    public function searchAction()
    {
        return new Response('<html><body>search functionality is being worked on</body></html>');
    }

    /**
     * @Route(name="load", path="/load")
     */
    public function loadAction()
    {
        $ads = [
            ['soehdvbzoef', 1500],
            ['Test', 5000],
            ['Yop yop yop', 1200],
            ['Honey, my money', 800],
        ];

        $entitymanager = $this
            ->getDoctrine()
            ->getManager()
        ;

        foreach ($ads as $data)
        {
            $ad = new Ad();
            $ad->setTitle($data[0]);
            $ad->setPrice($data[1]);
            $ad->setDatecreated(new DateTime());
            $entitymanager->persist($ad);
        }
        $entitymanager->flush();

        return new Response('<html><body>The ads table has been added successfully</body></html>');
    }
}