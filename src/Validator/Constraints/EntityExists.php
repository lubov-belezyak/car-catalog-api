<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class EntityExists extends Constraint
{
    public string $message = 'The entity with ID {{ value }} does not exist.';
    public string $entityClass;

    public function __construct(string $entityClass, ?string $message = null)
    {
        parent::__construct();
        $this->entityClass = $entityClass;
        if ($message !== null) {
            $this->message = $message;
        }
    }
}