<?php
// src/Repository/ContactRepository.php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    // Exemple de requête personnalisée :
    // public function findByRecent(): array
    // {
    //     return $this->createQueryBuilder('c')
    //         ->orderBy('c.createdAt', 'DESC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult();
    // }
}
