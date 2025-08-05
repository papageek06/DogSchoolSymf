<?php

// src/Controller/ContactController.php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            // Envoi de l'email (facultatif, à adapter)
            $email = (new Email())
                ->from($contact->getEmail())
                ->to('marc.longmar@gmail.com') // Remplace par ton email réel
                ->cc('christian.longmar@gmail.com')
                ->subject('Nouveau message via le formulaire de contact')
                ->text("Nom : {$contact->getName()}\n\nSujet : {$contact->getSubject()}\n\nMessage :\n{$contact->getMessage()}");

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé. Nous vous répondrons rapidement.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
             'contactForm' => $form->createView(),
        ]);
    }
}
