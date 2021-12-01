<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

     public function findPostWithCategory(int $id) {

         $qb = $this->createQueryBuilder('p');
         $qb->select('p.title')
                ->addSelect('p.id AS post_id')
                ->addSelect('c.name')
                ->addSelect('c.id AS cat_id')
                ->innerJoin('p.category', 'c')
                ->where('p.id = :id')
                ->setParameter('id', $id)
        ;
        return $qb->getQuery()->getResult();
     }

   
}
