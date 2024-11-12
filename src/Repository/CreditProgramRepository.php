<?php

namespace App\Repository;

use App\Entity\CreditProgram;
use App\Request\CalculateCreditProgramRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreditProgram>
 */
class CreditProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditProgram::class);
    }

    public function selectCreditProgram(CalculateCreditProgramRequest $request): CreditProgram
    {
        // проходит порог минимальной цены
        $qb = $this->createQueryBuilder('cp')
            ->where('cp.minPrice IS NULL OR cp.minPrice IS NULL OR cp.minPrice <= :price')
            ->setParameter('price', $request->price);


        // проходил ли % минимального платежа
        if ($request->initialPayment){
            $initialPaymentPercentage = ($request->initialPayment / $request->price) * 100;
            $qb->andWhere('cp.minInitialPaymentPercentage IS NULL OR cp.minInitialPaymentPercentage <= :initialPaymentPercentage')
                ->setParameter('initialPaymentPercentage', $initialPaymentPercentage);
        }

        // проверка на максимальный срок кредита
        if ($request->loanTerm) {
            $qb->andWhere('cp.maxLoanTerm IS NULL OR cp.maxLoanTerm >= :loanTerm')
                ->setParameter('loanTerm', $request->loanTerm);
        }

        $qb->setMaxResults(1);
        $program = $qb->getQuery()->getOneOrNullResult();

        if (!$program) {
            $program = $this->findOneBy(['title' => 'Standard']);
        }

        return $program;
    }

    private function findStandardProgram(): ?CreditProgram
    {
        return $this->findOneBy(['title' => 'Standard']);
    }
}
