<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_index")
     */
    public function categoryIndex() {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render("category/index.html.twig",
        [
            'categories' => $categories
        ]);
    }
    /**
     * @Route("/category/detail/{id}", name="category_detail")
     */
    public function categoryDetail($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category == null){
            $this->addFlash("Error", "Category was not existed!");
            return $this->redirectToRoute('category_index');
        }
        return $this->render(
            "category/detail.html.twig",
            [
                'category' => $category
            ]
        );
    }
    /**
     * @Route("/category/delete/{id}", name = "category_delete")
     */
    public function categoryDelete($id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category == null) {
            $this->addFlash("Error", "Category delete failed");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash("Success", "Category delete succeed");
        }
        return $this->redirectToRoute("category_index");
    }

     /**
     * @Route("/category/add", name = "category_add")
     */
    public function categoryAdd(Request $request) {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("Success", "Add category succeed");
            return $this->redirectToRoute("category_index");
        }

        return $this->renderForm("category/add.html.twig",
        [
            'categoryForm' => $form
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name = "category_edit")
     */
    public function genreEdit(Request $request, $id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("Success", "Edit category succeed");
            return $this->redirectToRoute("category_index");
        }

        return $this->renderForm("category/edit.html.twig",
        [
            'categoryForm' => $form
        ]);
    }
}
