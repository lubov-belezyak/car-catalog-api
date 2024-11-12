<?php

namespace App\Service;

use App\Dto\CreditProgramDto;
use App\Entity\CreditProgram;
use App\Request\CalculateCreditProgramRequest;
use App\Repository\CreditProgramRepository;

class CreditCalculatorService
{
    private CreditProgramRepository $creditProgramRepository;

    public function __construct(CreditProgramRepository $creditProgramRepository)
    {
        $this->creditProgramRepository = $creditProgramRepository;
    }

    public function calculateMonthlyPayment(CalculateCreditProgramRequest $request): CreditProgramDto
    {
        $program = $this->selectCreditProgram($request);

        $loanAmount = $request->price - $request->initialPayment;
        $interestRate = $program->getInterestRate() / 100 / 12;
        $loanTermMonths = $request->loanTerm;

        $monthlyPayment = $loanAmount * $interestRate / (1 - pow(1 + $interestRate, -$loanTermMonths));
        $monthlyPayment = round($monthlyPayment, 2);

        return new CreditProgramDto($program->getId(), $program->getInterestRate(), (int)$monthlyPayment, $program->getTitle());
    }

    private function selectCreditProgram(CalculateCreditProgramRequest $request): CreditProgram
    {
        return $this->creditProgramRepository->selectCreditProgram($request);
    }
}
