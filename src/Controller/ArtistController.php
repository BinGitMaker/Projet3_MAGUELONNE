<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use Doctrine\ORM\EntityManager;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/artist", name="artist_")
 */

class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ArtistRepository $artistRepository, PaginatorInterface $paginator, Request $request): Response
    {
            $queryArtist = $artistRepository->queryFindAll();
            /*pagination*/
            $limit = 10;
            $pagination = $paginator->paginate(
                $queryArtist, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                $limit /*limit per page*/
            );

        return $this->render('artist/index.html.twig', [
            'artists' => $artistRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

    /**
     * Getting an artist by id
     * @Route("/{slug}", name="show")
     * @return Response
     */
    public function show(Artist $artist): Response
    {
        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }
}
