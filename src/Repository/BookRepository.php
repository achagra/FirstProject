<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function searchBookByAuthor( String $author )  {
        $req = $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')  
            ->andWhere('a.username LIKE :author')
            ->setParameter('author', '%' . $author . '%')
               ->getQuery()->getResult();
            return $req;
    }

    public function BookListByAuthor (  ) {
        $req = $this->createQueryBuilder('b')
        ->leftJoin('b.author' , 'a')
        ->orderBy('a.username' , 'ASC')
        
        ->getQuery()->getResult();
        return $req;
    }

    public function booksBefore2022MultipleAuthors(): array
{
    return $this->createQueryBuilder('b')
        ->leftJoin('b.author', 'a')
        ->where('b.publicationDate < :date2025')  
        ->andWhere('b.published = :true')           
        ->andWhere('a.id IN (                       
            SELECT a2.id FROM App\Entity\Book b2 
            JOIN b2.author a2 
            WHERE b2.published = :true 
            GROUP BY a2.id 
            HAVING COUNT(b2) > 0
        )')
        ->setParameter('date2025', new \DateTime('2025-01-01'))
        ->setParameter('true', true)
        ->getQuery()->getResult();
}

    


}
