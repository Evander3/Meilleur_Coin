<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route(name="category_", path="/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route(name="new", path="/new")
     */
    public function newAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entitymanager = $this
                ->getDoctrine()
                ->getManager()
            ;
            $entitymanager->persist($category);
            $entitymanager->flush();
        }

        return $this->render('country/new.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route(name="add", path="/add/{catName}")
     */
    public function addAction($catName)
    {
        $entitymanager = $this
            ->getDoctrine()
            ->getManager()
        ;
        $cat = new Category();
        $cat->setCatName($catName);

        $entitymanager->persist($cat);
        $entitymanager->flush();

        return new Response("Added the category $catName");
    }


}