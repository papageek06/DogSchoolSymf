<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom *',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre prénom']),
                    new Length(['min' => 2, 'minMessage' => 'Le prénom doit faire au moins {{ limit }} caractères']),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre adresse email']),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
    'type' => PasswordType::class,
    'first_options' => [
        'label' => 'Mot de passe',
        'attr' => ['autocomplete' => 'new-password'],
    ],
    'second_options' => [
        'label' => 'Confirmez le mot de passe',
        'attr' => ['autocomplete' => 'new-password'],
    ],
    'invalid_message' => 'Les mots de passe ne correspondent pas.',
    'mapped' => false,
    'constraints' => [
        new NotBlank([
            'message' => 'Veuillez entrer un mot de passe',
        ]),
        new Length([
            'min' => 6,
            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
            'max' => 4096,
        ]),
        new Regex([
            'pattern' => '/^(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]).{6,}$/',
            'message' => 'Le mot de passe doit contenir au moins une majuscule et un caractère spécial.',
        ]),
    ],
])

            ->add('birthDate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'required' => false,
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo de profil (JPEG, PNG)',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Merci de choisir une image valide (JPEG ou PNG)',
                    ])
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J’accepte les conditions générales',
                'constraints' => [
                    new NotBlank(['message' => 'Vous devez accepter les conditions']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
