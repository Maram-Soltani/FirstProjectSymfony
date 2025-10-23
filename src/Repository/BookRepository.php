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
public function searchBookByRef($ref)
{
    return $this->createQueryBuilder('b')
        ->andWhere('b.ref LIKE :ref')
        ->setParameter('ref', '%' . $ref . '%')
        ->getQuery()
        ->getResult();
}

public function booksListByAuthors()
{
    return $this->createQueryBuilder('b')
        ->join('b.author', 'a')
        ->addSelect('a')
        ->orderBy('a.username', 'ASC')
        ->addOrderBy('b.title', 'ASC')
        ->getQuery()
        ->getResult();
}

///2023

public function findBooksBefore2023WithAuthorHavingMoreThan10Books()
{
    return $this->createQueryBuilder('b')
        ->join('b.author', 'a')
        ->addSelect('a')
        ->where('b.publicationDate < :date')
        ->andWhere('(
            SELECT COUNT(b2.id)
            FROM App\Entity\Book b2
            WHERE b2.author = a
        ) > 10')
        ->setParameter('date', new \DateTime('2023-01-01'))
        ->getQuery()
        ->getResult();
}

public function listeBooks(BookRepository $bookRepository): Response
{
    $books = $bookRepository->findAll();

    // Compter les livres de catégorie "Romance"
    $romanceCount = 0;
    foreach ($books as $book) {
        if ($book->getCategory() === 'Romance') {
            $romanceCount++;
        }
    }

    return $this->render('book/liste.html.twig', [
        'books' => $books,
        'romanceCount' => $romanceCount,
    ]);
}
public function countPublished(): int
{
    return $this->createQueryBuilder('b')
        ->select('COUNT(b.id)')
        ->where('b.published = :val')
        ->setParameter('val', true)
        ->getQuery()
        ->getSingleScalarResult();
}

public function countUnpublished(): int
{
    return $this->createQueryBuilder('b')
        ->select('COUNT(b.id)')
        ->where('b.published = :val')
        ->setParameter('val', false)
        ->getQuery()
        ->getSingleScalarResult();
}

public function countByCategory(string $category): int
{
    return $this->createQueryBuilder('b')
        ->select('COUNT(b.id)')
        ->where('b.category = :cat')
        ->setParameter('cat', $category)
        ->getQuery()
        ->getSingleScalarResult();
}

   public function findBooksBetweenDates($startDate, $endDate)
{
    return $this->createQueryBuilder('b')
        ->where('b.publicationDate BETWEEN :start AND :end')
        ->setParameter('start', $startDate)
        ->setParameter('end', $endDate)
        ->getQuery()
        ->getResult();
}


public function findAuthorsByBookCountRange(int $min, int $max)
{
    return $this->createQueryBuilder('a')
        ->where('a.nbBooks BETWEEN :min AND :max')
        ->setParameter('min', $min)
        ->setParameter('max', $max)
        ->getQuery()
        ->getResult();
}

}
