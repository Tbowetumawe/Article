<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

use Doctrine\ORM\Query\AST\Join;



/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    
    public function findAllArt()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function rechercherParCateg($id) 
    {
        $qb = $this->_em->createQueryBuilder('a');
        
        $qb->select('a')     
            ->from(Article::class,'a')
            ->innerJoin(Categorie::class, 'c', 'WITH','c.id = a.categorie')
            ->where ('c.id = :id')
            ->setParameter('id',$id);        
        $query = $qb->getQuery();
        $result = $query->getResult();
       
        return $result;    
    }
  
    public function rechercherParCateg1($id) 
    {
        $ss_qb = $this->_em->createQueryBuilder();
        $ss_qb->select('c.id')
            ->from(Categorie::class, 'c')
            ->where('c.id = :id');

        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from(Article::class, 'a')
            ->where($qb->expr()->in('a.categorie', $ss_qb->getDQL()))
            ->setParameter('id', $id);
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;   
    }
   
    public function getUnArticle($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from(Article::class,'a')
            ->where('a.id = :id')
            ->setParameter('id', $id);
        
        $query = $qb->getQuery();
        
        $result = $query->getResult();
        
        return $result;
    }

}
