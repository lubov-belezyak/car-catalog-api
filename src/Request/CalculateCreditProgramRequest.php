<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CalculateCreditProgramRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'Price is required')]
        #[Assert\Type(type: 'integer', message: 'Price must be an integer')]
        #[Assert\Positive(message: 'Price must be positive')]
        public int   $price,

        #[Assert\NotBlank(message: 'Initial payment is required')]
        #[Assert\Type(type: 'float', message: 'Initial payment must be a float')]
        #[Assert\GreaterThanOrEqual(0, message: 'Initial payment must be non-negative')]
        public float $initialPayment,

        #[Assert\NotBlank(message: 'Loan term is required')]
        #[Assert\Type(type: 'integer', message: 'Loan term must be an integer')]
        #[Assert\Positive(message: 'Loan term must be positive')]
        public int   $loanTerm
    )
    {
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->initialPayment > $this->price) {
            $context
                ->buildViolation('The initial payment cannot exceed the price.')
                ->atPath('initialPayment')
                ->addViolation();
        }
    }
}
