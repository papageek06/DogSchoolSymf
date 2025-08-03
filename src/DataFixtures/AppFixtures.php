<?php

namespace App\DataFixtures;

use App\Entity\Icon;
use App\Entity\Service;
use App\Entity\ServiceFeature;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $icons = [];

        $iconData = [
            ['fa-graduation-cap', 'Graduation Cap', 'education'],
            ['fa-brain', 'Brain', 'education'],
            ['fa-running', 'Running', 'activity'],
            ['fa-heart', 'Heart', 'emotion'],
            ['fa-user-friends', 'User Friends', 'people'],
            ['fa-star', 'Star', 'general'],
        ];

        foreach ($iconData as $index => [$class, $name, $category]) {
            $icon = new Icon();
            $icon->setIconClass($class);
            $icon->setName($name);
            $icon->setCategory($category);
            $manager->persist($icon);
            $icons[$index] = $icon;
        }

        $servicesData = [
            [
                'title' => 'Dressage de Base',
                'description' => "Apprenez les commandes essentielles avec votre chien : assis, couché, reste, au pied.",
                'price' => 45.00,
                'duration' => '1h',
                'icon' => $icons[0],
                'is_featured' => false,
                'features' => ['Commandes de base', 'Marche en laisse', 'Rappel', 'Socialisation']
            ],
            [
                'title' => 'Éducation Avancée',
                'description' => "Perfectionnez l'obéissance et développez les compétences de votre chien.",
                'price' => 50.00,
                'duration' => '1h',
                'icon' => $icons[1],
                'is_featured' => false,
                'features' => ['Obéissance avancée', 'Commandes à distance', 'Contrôle des impulsions', 'Préparation aux concours']
            ],
            [
                'title' => 'Agility',
                'description' => "Découvrez l'agility pour stimuler votre chien physiquement et mentalement.",
                'price' => 55.00,
                'duration' => '1h30',
                'icon' => $icons[2],
                'is_featured' => false,
                'features' => ["Parcours d'obstacles", 'Coordination', 'Confiance en soi', 'Exercice physique']
            ],
            [
                'title' => 'Comportement',
                'description' => "Résolution des problèmes de comportement : aboiements, agressivité, anxiété.",
                'price' => 60.00,
                'duration' => '1h',
                'icon' => $icons[3],
                'is_featured' => false,
                'features' => ['Analyse comportementale', "Gestion de l'anxiété", 'Contrôle des aboiements', 'Socialisation']
            ],
            [
                'title' => 'Cours Particuliers',
                'description' => "Cours personnalisés à domicile ou dans nos locaux, adaptés à vos besoins spécifiques.",
                'price' => 70.00,
                'duration' => '1h',
                'icon' => $icons[4],
                'is_featured' => false,
                'features' => ['Programme sur mesure', 'Suivi personnalisé', 'Flexibilité horaire', 'Progrès rapides']
            ],
            [
                'title' => 'Forfaits',
                'description' => "Économisez avec nos forfaits et progressez plus rapidement.",
                'price' => 0.00,
                'duration' => 'Sur devis',
                'icon' => $icons[5],
                'is_featured' => true,
                'features' => ['10 séances : -15%', '20 séances : -25%', 'Suivi personnalisé', 'Support pédagogique']
            ],
        ];

        foreach ($servicesData as $data) {
            $service = new Service();
            $service->setTitle($data['title']);
            $service->setDescription($data['description']);
            $service->setPrice($data['price']);
            $service->setDuration($data['duration']);
            $service->setIcon($data['icon']);
            $service->setIsFeatured($data['is_featured']);
            $manager->persist($service);

            foreach ($data['features'] as $featureTitle) {
                $feature = new ServiceFeature();
                $feature->setTitle($featureTitle);
                $feature->setService($service);
                $manager->persist($feature);
            }
        }

        $manager->flush();
    }
}
