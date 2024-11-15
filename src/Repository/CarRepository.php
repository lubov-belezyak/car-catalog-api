<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Car::class);
        $this->paginator = $paginator;
    }

    public function getCarsListWithPagination(int $page = 1): PaginationInterface
    {
        $page = max($page, 1);
        $limit = 10;

        $queryBuilder = $this->createQueryBuilder('c')
            ->leftJoin('c.brand', 'b')
            ->addSelect('b')
            ->orderBy('c.id', 'ASC');

        return $this->paginator->paginate(
            $queryBuilder,
            $page,
            $limit
        );
    }
}
