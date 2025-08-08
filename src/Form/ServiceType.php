<?php

namespace App\Form;

use App\Entity\Icon;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            // ->add('price')
            ->add('price', NumberType::class, [
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'step' => 0.01, // Permet d'entrer des centimes
                    'min' => 0,
                    'class' => 'form-control',
                ],
            ])
            
            ->add('duration')
            ->add('isFeatured')
            ->add('backgroundColor')
            ->add('textColor')
            ->add('buttonColor')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
           ->add('icon', ChoiceType::class, [
    'label' => 'Icône',
    'choices' => $options['icons'],
    'choice_label' => function ($icon) {
        return $icon->getIconClass(); // nom affiché si tu ne personnalises pas le HTML
    },
    'choice_attr' => function ($icon, $key, $value) {
        return [
            'class' => 'form-check-input visually-hidden',
            'data-icon' => $icon->getIconClass(),
        ];
    },
    'expanded' => true,
    'multiple' => false,
])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
            'icons' => [],
        ]);
    }
}
