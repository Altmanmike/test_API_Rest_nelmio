<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $developersData = [
            [
                'title' => 'Développeur Full Stack Senior (PHP/JS)',
                'description' => 'Expert en écosystèmes Symfony et React, avec un accent sur les applications web performantes et sécurisées.',
                'companies' => ['TechInnov Solutions', 'WebForce Dynamics'],
                'experience' => 8,
                'participant' => true,
                'createdAt' => '2023-10-01 10:00:00',
                'updatedAt' => '2024-03-15 14:30:00',
            ],
            [
                'title' => 'Développeuse Backend Confirmée (Symfony)',
                'description' => 'Spécialisée en architecture microservices et API RESTful avec une solide expérience Doctrine ORM.',
                'companies' => ['API Central', 'DataStream Inc.'],
                'experience' => 5,
                'participant' => true,
                'createdAt' => '2023-08-20 09:15:00',
                'updatedAt' => '2024-04-01 11:00:00',
            ],
            [
                'title' => 'Développeur Junior (Apprentissage Symfony)',
                'description' => 'Passionné par le développement web, cherche à monter en compétence sur Symfony et les pratiques de code propres.',
                'companies' => ['Startup XYZ'],
                'experience' => 1,
                'participant' => false,
                'createdAt' => '2024-01-10 14:00:00',
                'updatedAt' => '2024-05-10 16:45:00',
            ],
            [
                'title' => 'Ingénieure Logiciel DevOps',
                'description' => 'Expertise en CI/CD, Docker, Kubernetes, et automatisation des déploiements d\'applications Symfony.',
                'companies' => ['CloudOps Gen', 'InfraCode'],
                'experience' => 7,
                'participant' => true,
                'createdAt' => '2022-11-05 11:30:00',
                'updatedAt' => '2024-02-28 09:00:00',
            ],
            [
                'title' => 'Développeur Frontend (Vue.js)',
                'description' => 'Bien que spécialisé en Vue.js, bonne connaissance de Twig et de l\'intégration avec le backend Symfony.',
                'companies' => ['UI/UX Masters'],
                'experience' => 4,
                'participant' => false,
                'createdAt' => '2023-05-18 10:45:00',
                'updatedAt' => '2024-05-05 13:15:00',
            ],
            [
                'title' => 'Architecte PHP/Symfony',
                'description' => 'Conçoit et supervise l\'implémentation des systèmes complexes basés sur le framework Symfony.',
                'companies' => ['Global Solutions Architects', 'Enterprise Sys'],
                'experience' => 12,
                'participant' => true,
                'createdAt' => '2021-03-01 08:00:00',
                'updatedAt' => '2024-01-01 10:00:00',
            ],
            [
                'title' => 'Développeur Mobile (Flutter/API Symfony)',
                'description' => 'Développe des applications mobiles qui interagissent avec des API RESTful construites avec Symfony.',
                'companies' => ['Mobile First Dev'],
                'experience' => 6,
                'participant' => true,
                'createdAt' => '2022-09-15 15:00:00',
                'updatedAt' => '2024-04-20 17:00:00',
            ],
            [
                'title' => 'Stagiaire Dev (PHP)',
                'description' => 'Actuellement en stage, contribue à des modules simples et apprend les bases de Symfony.',
                'companies' => ['Internship Hub'],
                'experience' => 0,
                'participant' => false,
                'createdAt' => '2024-05-01 10:00:00',
                'updatedAt' => '2024-05-01 10:00:00',
            ],
            [
                'title' => 'Consultant Technique Symfony',
                'description' => 'Aide les entreprises à optimiser leurs applications Symfony existantes et à migrer vers de nouvelles versions.',
                'companies' => ['Tech Consulting Group'],
                'experience' => 10,
                'participant' => true,
                'createdAt' => '2022-01-25 11:20:00',
                'updatedAt' => '2024-03-01 12:00:00',
            ],
            [
                'title' => 'Développeuse E-commerce (Sylius/Symfony)',
                'description' => 'Spécialisée dans la mise en œuvre et la personnalisation de solutions E-commerce basées sur Sylius et Symfony.',
                'companies' => ['Ecom Builders'],
                'experience' => 5,
                'participant' => true,
                'createdAt' => '2023-02-14 09:00:00',
                'updatedAt' => '2024-04-10 15:30:00',
            ],
        ];

        foreach($developersData as $dataDev) {
            $dev = new Developer();
            $dev->setTitle($dataDev['title'])
                ->setDescription($dataDev['description'])
                ->setCompanies($dataDev['companies'])
                ->setExperience($dataDev['experience'])
                ->setisParticipant($dataDev['participant'])
                ->setCreatedAt(new \DateTimeImmutable($dataDev['createdAt']))
                ->setUpdatedAt(new \DateTimeImmutable($dataDev['updatedAt']));

                $manager->persist($dev);                
        }         

        $manager->flush();
    }
}