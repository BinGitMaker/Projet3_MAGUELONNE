<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contactFormData = $contactForm->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('maguelonne@mail.com')
                ->subject('Maguelonne - ' . $contactFormData['title'])
                ->html(
                    $this->renderView(
                        'emails/newContact.html.twig',
                        [
                            'contactForm' => $contactFormData
                        ]
                    )
                );
            $mailer->send($message);
            $this->addFlash('success', 'Vore message a été envoyé!');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
