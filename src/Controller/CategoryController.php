<?php

// src/Controller/CategoryController.php

namespace App\Controller;

//use App\Entity\Category;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categorys = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categorys' => $categorys,
         ]);
    }

    #[Route('category/new', name: 'newcategory')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);                
            return $this->redirectToRoute('category_index');
        }

        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/category/{name}', name: 'category_show')]
     public function show(string $name, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
     {
        $category = $categoryRepository->findOneByName(['name' => $name]);
        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : '.$name.' found in category\'s table.'
            );}

        $programs = $programRepository->findBy(['category' => $category]);
        if (!$programs) {
            throw $this->createNotFoundException(
                'No category with categoryName : '.$category.' found in category\'s table.'
            );
        }
         return $this->render('category/show.html.twig', ['programs' => $programs, 'category' => $category]);
     }
}
