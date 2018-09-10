<?php

namespace AppBundle\Controller;

use AppBundle\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Ad;
use DateTime;

/**
 * @Route(name="ad_", path="/ad")
 */
class AdController extends Controller
{
    /**
     * @Route(name="add", path="/add/{adName}")
     */
    public function addAction($adName)
    {
        $entitymanager = $this
            ->getDoctrine()
            ->getManager()
        ;
        $ad = new Ad();
        $ad->setTitle($adName);
        $ad->setDescription("C'est vraiment très très bien !");
        $ad->setCity('Saint-Herblain');
        $ad->setZip(44480);
        $ad->setPrice(2250);
        $objDateTime = new DateTime('NOW');
        $objDateTime->format('Y-m-d');
        $ad->setDatecreated($objDateTime);

        $entitymanager->persist($ad);
        $entitymanager->flush();

        return new Response("Added the ad $adName");
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
}