<?php

namespace App\Controller\Admin;

use App\Entity\FriendLink;
use App\Form\FriendLinkType;
use App\Repository\FriendLinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/friendlink", name="friendlink_")
 */
class FriendLinkController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(FriendLinkRepository $friendLinkRepository): Response
    {
        return $this->render('admin/friend_link/index.html.twig', [
            'friend_links' => $friendLinkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $friendLink = new FriendLink();
        $form = $this->createForm(FriendLinkType::class, $friendLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($friendLink);
            $entityManager->flush();

            return $this->redirectToRoute('admin_friendlink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/friend_link/new.html.twig', [
            'friend_link' => $friendLink,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FriendLink $friendLink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FriendLinkType::class, $friendLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_friendlink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/friend_link/edit.html.twig', [
            'friend_link' => $friendLink,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, FriendLink $friendLink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $friendLink->getId(), $request->request->get('_token'))) {
            $entityManager->remove($friendLink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_friendlink_index', [], Response::HTTP_SEE_OTHER);
    }
}
