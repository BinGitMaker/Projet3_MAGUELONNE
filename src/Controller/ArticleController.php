<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\ArticleTranslation;
use App\Repository\ArticleRepository;
use App\Repository\ArticleCategoryRepository;
use App\Repository\ArticleTranslationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({
 *     "fr": "/blog",
 *     "en": "/blog",
 *     "de": "/blog",
 *     "ru": "/блог",
 *     "ja": "/ブロッグ"
 * }, name="article_")
 */
class ArticleController extends AbstractController
{
    /**
     * @var array
     */
    private array $filters;
    /**
     * @Route("/", name="index", methods={"GET","POST"})
     */
    public function index(
        ArticleRepository $articleRepository,
        ArticleCategoryRepository $articleCatRepo,
        Request $request,
        PaginatorInterface $paginator
    ): Response {

        /*filters*/
        $hasFilters = isset($_GET['form']['categories']);
        $this->filters = $hasFilters ? $_GET['form']['categories'] : [];
        $categories = $articleCatRepo->findBy(['id' => $this->filters]);
        $queryArticles = $hasFilters ?
            $articleRepository->findByCategory($categories) :
            $articleRepository->queryFindAll();

        /*pagination*/
        $limit = 10;
        $pagination = $paginator->paginate(
            $queryArticles, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $limit /*limit per page*/
        );

        /*form*/
        $form = $this->createFormBuilder([])
        ->add('categories', EntityType::class, [
            'class' => ArticleCategory::class,
            'choice_label' => function (ArticleCategory $articleCategory) {
                return $articleCategory->getName();
            },
            'choice_attr' => function (ArticleCategory $articleCategory) {
                return in_array($articleCategory->getId(), $this->filters) ? ['checked' => 'true'] : [];
            },
            'multiple' => true,
            'expanded' => true,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'filtrer'])
        ->getForm();


        return $this->renderForm('article/index.html.twig', [
            'categories' => $categories,
            'pagination' => $pagination,
            'articleCategories' => $articleCatRepo->findAll(),
            'formCategoryFilter' => $form,
            'paginationLimit' => $limit
        ]);
    }

    /**
     * Getting an article by id
     * @Route("/{slug}", name="show", methods={"GET"})
     * @return Response
     */
    public function show(ArticleTranslation $articleTranslation): Response
    {
        $article = $articleTranslation->getTranslatable();
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
