<?php

namespace App\Validator\Constraints;

use App\Repository\CarRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CarInitialPaymentValidator extends ConstraintValidator
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CarInitialPayment) {
            throw new UnexpectedTypeException($constraint, CarInitialPayment::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_numeric($value)) {
            throw new UnexpectedValueException($value, 'float');
        }

        $carId = $this->context->getRoot()->carId;
        $car = $this->carRepository->find($carId);

        if ($car && $value > $car->getPrice()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('initialPayment')
                ->addViolation();
        }
    }
}