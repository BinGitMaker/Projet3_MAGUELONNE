<?php

namespace App\Controller;

use App\Entity\Content;
use App\Repository\ContentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/", name="page_")
 */
class ContentController extends AbstractController
{
    public function renderTwig(ContentRepository $contentRepository): Response
    {
        return $this->render('_footer.html.twig', [
            'content' => $contentRepository->findOneBy(
                [
                    'identifier' => 'footer',
                ]
            )
        ]);
    }

    /**
     * @Route("/{slug}", name="show", priority="-1", methods={"GET"})
     */
    public function show(Content $content): Response
    {
        return $this->render(
            'content/show.html.twig',
            [
                'content' => $content,
            ]
        );
    }
}
