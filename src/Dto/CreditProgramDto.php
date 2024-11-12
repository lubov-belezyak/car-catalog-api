<?php

namespace App\Dto;

class CreditProgramDto
{
    private int $id;
    private float $interestRate;
    private int $monthlyPayment;
    private string $title;

    public function __construct(int $id, float $interestRate, float $monthlyPayment, string $title)
    {
        $this->id = $id;
        $this->interestRate = $interestRate;
        $this->monthlyPayment = $monthlyPayment;
        $this->title = $title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getMonthlyPayment(): int
    {
        return $this->monthlyPayment;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}