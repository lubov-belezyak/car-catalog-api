<?php

namespace App\Request;

use App\Entity\CreditProgram;
use App\Repository\CarRepository;
use App\Repository\CreditProgramRepository;
use App\Validator\Constraints\CarInitialPayment;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Validator\Constraints\EntityExists;
use App\Entity\Car;

class ApplicationRequest
{
    public function __construct(
        #[NotBlank(message: 'Car ID is required')]
        #[Type(type: 'integer', message: 'Car ID must be an integer')]
        #[EntityExists(entityClass: Car::class, message: 'Car with ID {{ value }} does not exist')]
        public int   $carId,

        #[NotBlank(message: 'Credit program ID is required')]
        #[Type(type: 'integer', message: 'Credit program ID must be an integer')]
        #[EntityExists(entityClass: CreditProgram::class, message: 'Credit program with ID {{ value }} does not exist')]
        public int   $creditProgramId,

        #[NotBlank(message: 'Initial payment is required')]
        #[Type(type: 'float', message: 'Initial payment must be a float')]
        #[GreaterThanOrEqual(0, message: 'Initial payment must be non-negative')]
        #[CarInitialPayment]
        public float $initialPayment,

        #[NotBlank(message: 'Loan term is required')]
        #[Type(type: 'integer', message: 'Loan term must be an integer')]
        #[Positive(message: 'Loan term must be positive')]
        #[LessThanOrEqual(120, message: 'Loan term must be less than or equal to 120')]
        public int   $loanTerm,
    )
    {
    }
}