<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Media::class);
    }

    // /**
    //  * @return Media[] Returns an array of Media objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function getMusic()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.category = :val')
            ->setParameter('val', 1)
            ->getQuery()
            ->getResult();
    }

    public function getVideo()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.category = :val')
            ->setParameter('val', 2)
            ->getQuery()
            ->getResult();
    }

    public function getPodcast()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.category = :val')
            ->setParameter('val', 3)
            ->getQuery()
            ->getResult();
    }
}
