<?php
// src/Form/ContactType.php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom complet *',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre nom']),
                ],
                'attr' => [
                    'placeholder' => 'Votre nom',
                    'class' => 'form-control',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre adresse email']),
                    new Email(['message' => 'Adresse email invalide']),
                ],
                'attr' => [
                    'placeholder' => 'exemple@domaine.com',
                    'class' => 'form-control',
                ],
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Sujet *',
                'choices' => [
                    'Renseignements' => 'Renseignements',
                    'Réservation de cours' => 'Réservation',
                    'Demande de devis' => 'Devis',
                    'Problème comportemental' => 'Problème',
                    'Autre' => 'Autre',
                ],
                'placeholder' => 'Choisissez un sujet',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un sujet']),
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message *',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez écrire votre message']),
                ],
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Décrivez votre demande...',
                    'class' => 'form-control',
                ],
            ])
            ->add('privacy', CheckboxType::class, [
                'label' => 'J\'accepte la politique de confidentialité',
                'mapped' => false,
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter notre politique de confidentialité']),
                ],
                'attr' => ['class' => 'form-check-input me-2'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

