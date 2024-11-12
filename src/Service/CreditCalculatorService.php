<?php

namespace App\Service;

use App\Dto\CreditProgramDto;
use App\Entity\CreditProgram;
use App\Request\CalculateCreditProgramRequest;
use App\Repository\CreditProgramRepository;

class CreditCalculatorService
{
    private CreditProgramRepository $creditProgramRepository;
    private MonthlyPaymentCalculatorService $monthlyPaymentCalculatorService;

    public function __construct(CreditProgramRepository $creditProgramRepository,
                                MonthlyPaymentCalculatorService $paymentCalculatorService)
    {
        $this->creditProgramRepository = $creditProgramRepository;
        $this->monthlyPaymentCalculatorService = $paymentCalculatorService;
    }

    public function calculateMonthlyPayment(CalculateCreditProgramRequest $request): CreditProgramDto
    {
        $program = $this->selectCreditProgram($request);

        $loanAmount = $request->price - $request->initialPayment;
        $interestRate = $program->getInterestRate() / 100 / 12;
        $loanTermMonths = $request->loanTerm;

        $monthlyPayment = $this->monthlyPaymentCalculatorService->calculateMonthlyPayment($loanAmount, $interestRate, $loanTermMonths);

        return new CreditProgramDto($program->getId(), $program->getInterestRate(), (int)$monthlyPayment, $program->getTitle());
    }

    private function selectCreditProgram(CalculateCreditProgramRequest $request): CreditProgram
    {
        return $this->creditProgramRepository->selectCreditProgram($request);
    }
}
