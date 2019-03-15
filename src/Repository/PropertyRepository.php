<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    //nouvelle methode public
    /**
      * @return Property[]
      */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
            //conditions
            //->Where('p.sold = false')
            //->setParameter('val', $value)
            //->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            //recupere la requete
            ->getQuery()
            // recup le resultat
            ->getResult();
    }

    /**
     * 
     * @Return Property[];
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    
    // Retourne un objet de type QueryBuilder
    // cette methode affecte les autres fonctions find
    private function findVisibleQuery(): QueryBuilder
    {   
        // retourne un objet queryBuilder
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }



    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
