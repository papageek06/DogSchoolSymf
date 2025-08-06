<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\ImageConverterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger,
        ImageConverterService $imageConverter
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mot de passe
            $plainPassword = $form->get('plainPassword')->getData();
            dd($plainPassword);

            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Date de création
            $user->setCreatedAt(new \DateTimeImmutable());

            // Rôle par défaut
            $user->setRoles(['ROLE_USER']);

            // Compte non vérifié au départ
            $user->setIsVerified(false);

            // Gestion de la photo
            $picture = $form->get('picture')->getData();

            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $tempFilename = uniqid();
                $originalExtension = $picture->guessExtension();

                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/users/';
                $originalPath = $destination . $safeFilename . '-' . $tempFilename . '.' . $originalExtension;
                $webpFilename = $safeFilename . '-' . $tempFilename . '.webp';
                $webpPath = $destination . $webpFilename;

                try {
                    // On devine d'abord le type avant de déplacer
                    $picture->move($destination, basename($originalPath));

                    // Convertir en WebP
                    $imageConverter->convertToWebP($originalPath, $webpPath);

                    // Supprimer l'image originale
                    unlink($originalPath);

                    // Enregistrer le nom du fichier WebP
                    $user->setPicture('uploads/users/' . $webpFilename);
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors de l’upload ou de la conversion de l’image : ' . $e->getMessage());
                }
            }

            // Enregistrement en BDD
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
