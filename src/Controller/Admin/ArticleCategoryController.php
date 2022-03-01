<?php

namespace App\Controller\Admin;

use App\Entity\ArticleCategory;
use App\Form\ArticleCategoryType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articleCategory", name="articleCategory_")
 */
class ArticleCategoryController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ArticleCategoryRepository $articleCatRepo): Response
    {
        return $this->render('admin/articleCategory/index.html.twig', [
            'article_categories' => $articleCatRepo->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articleCategory = new ArticleCategory();
        $form = $this->createForm(ArticleCategoryType::class, $articleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($articleCategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_articleCategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/articleCategory/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        ArticleCategory $articleCategory,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ArticleCategoryType::class, $articleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_articleCategory_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/articleCategory/edit.html.twig', [
            'articleCategory' => $articleCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        ArticleCategory $articleCategory,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $articleCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($articleCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_articleCategory_index', [], Response::HTTP_SEE_OTHER);
    }
}
