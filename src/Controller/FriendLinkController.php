<?php

namespace App\Controller;

use App\Repository\FriendLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/friend_link", name="friendLink_")
 */

class FriendLinkController extends AbstractController
{
/**
 * @Route("/", name="index")
 */
    public function index(FriendLinkRepository $friendLinkRepository): Response
    {
        return $this->render('friendLink/index.html.twig', [
        'friend_links' => $friendLinkRepository->findAll(),
        ]);
    }
}
