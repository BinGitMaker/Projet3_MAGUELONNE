<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/association", name="association_")
 */
class AssociationController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ContentRepository $contentRepository): Response
    {
        return $this->render('association/index.html.twig', [
            'content' => $contentRepository->findOneBy([
                'identifier' => 'presentation-association'
            ])
        ]);
    }
}
