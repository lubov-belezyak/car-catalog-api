<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CarInitialPayment extends Constraint
{
    public string $message = 'The initial payment cannot exceed the price of the car.';

    public function validatedBy(): string
    {
        return CarInitialPaymentValidator::class;
    }
}