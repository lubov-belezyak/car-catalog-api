<?php

namespace App\Service;

class MonthlyPaymentCalculatorService
{
    public function calculateMonthlyPayment(float $loanAmount, float $interestRate, int $loanTermMonths): float
    {
        $monthlyInterestRate = $interestRate / 100 / 12;
        $monthlyPayment = $loanAmount * $monthlyInterestRate / (1 - pow(1 + $monthlyInterestRate, -$loanTermMonths));
        return round($monthlyPayment, 2);
    }
}