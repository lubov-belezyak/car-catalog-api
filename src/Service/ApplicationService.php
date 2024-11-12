<?php

namespace App\Service;

use App\Entity\Application;
use App\Entity\Car;
use App\Entity\CreditProgram;
use App\Repository\ApplicationRepository;
use App\Request\ApplicationRequest;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationService
{
    private ApplicationRepository $applicationRepository;
    private MonthlyPaymentCalculatorService $monthlyPaymentCalculatorService;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ApplicationRepository $applicationRepository,
        MonthlyPaymentCalculatorService $monthlyPaymentCalculatorService,
        EntityManagerInterface $entityManager
    ) {
        $this->applicationRepository = $applicationRepository;
        $this->monthlyPaymentCalculatorService = $monthlyPaymentCalculatorService;
        $this->entityManager = $entityManager;
    }

    public function createApplication(ApplicationRequest $request, Car $car, CreditProgram $creditProgram): Application
    {
        $loanAmount = $car->getPrice() - $request->initialPayment;
        $interestRate = $creditProgram->getInterestRate();
        $loanTermMonths = $request->loanTerm;

        $monthlyPayment = $this->monthlyPaymentCalculatorService->calculateMonthlyPayment($loanAmount, $interestRate, $loanTermMonths);

        $application = new Application();
        $application->setCar($car);
        $application->setCreditProgram($creditProgram);
        $application->setPrice($car->getPrice());
        $application->setInitialPayment($request->initialPayment);
        $application->setMonthlyPayment($monthlyPayment);

        $this->entityManager->persist($application);
        $this->entityManager->flush();

        return $application;
    }
}