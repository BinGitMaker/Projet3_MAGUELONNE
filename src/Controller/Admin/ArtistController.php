<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use App\Entity\ArtistTranslation;
use App\Repository\ArtistTranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/artist", name="artist_")
 */

class ArtistController extends AbstractTranslatorController
{
    private EntityManagerInterface $entityManager;

    /**
     * ArticleController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * lister les artistes
     * @Route("/", name="index")
     */
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('admin/artist/index.html.twig', [
            'artists' => $artistRepository->findAll(),
        ]);
    }

    /**
     * création du formulaire d'ajout d'un artiste
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locale = 'fr';
            $translation = new ArtistTranslation();
            $translation->setLocale($locale);
            $translation->setBody($form->getData()->getBody());
            $translation->setRepository($form->getData()->getRepository());
            $translation->setNationality($form->getData()->getNationality());
            $translation->setAlt($form->getData()->getAlt());
            $artist->setSlug($this->slug($locale, $form->getData()->getName()));
            $artist->addTranslation($translation);
            $entityManager->persist($artist);
            $entityManager->flush();
            return $this->redirectToRoute('admin_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artist/new.html.twig', [
            'form' => $form,
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Artist $artist): Response
    {
        return $this->render('admin/artist/show.html.twig', [
            'artists' => $artist,
        ]);
    }

    /**
     * Edition d'un artiste
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Artist $artist,
        EntityManagerInterface $entityManager
    ): Response {
        $locale = $request->query->get('locale');
        $artist->setCurrentLocale($locale);
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $translation = $artist->translate($locale, false);
            $translation->setBody($artist->getBody());
            $translation->setRepository($artist->getRepository());
            $translation->setNationality($artist->getNationality());
            $translation->setAlt($artist->getAlt());
            $artist->setSlug($this->slug($locale, $artist->getName()));
            $entityManager->flush();

            return $this->redirectToRoute('admin_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form
        ]);
    }

    /**
     * @param string $locale
     * @param Artist $artist
     * @return Response
     * @Route("/{id}/add-translation/{locale}", name="add_translation")
     */
    public function addTranslation(
        string $locale,
        Artist $artist
    ): Response {
        $translation = new ArtistTranslation();
        $translation->setLocale($locale);
        $translation->setBody($artist->getBody());
        $artist->addTranslation($translation);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_artist_edit', ['id' => $artist->getId(), 'locale' => $locale]);
    }

    /**
     * @Route("/{id}/delete-translation/{locale}", name="delete_translation", methods={"POST"})
     */
    public function deleteTranslation(
        Request $request,
        Artist $artist,
        string $locale,
        ArtistTranslationRepository $transRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $request->request->get('_token'))) {
            $translation = $transRepository->findOneBy([
                'locale' => $locale,
                'translatable' => $artist
            ]);
            if ($translation) {
                $artist->removeTranslation($translation);
                $this->entityManager->flush();
            }
        }

        return $this->redirectToRoute('admin_artist_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * formulaire de suppression d'un artiste
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $request->request->get('_token'))) {
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
