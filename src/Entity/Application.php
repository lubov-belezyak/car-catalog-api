<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CreditProgram $creditProgram = null;

    #[ORM\Column(options: ['unique' => true])]
    private ?int $price = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: ['unsigned' => true])]
    private ?string $initialPayment = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: ['unsigned' => true])]
    private ?string $monthlyPayment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function getCreditProgram(): ?CreditProgram
    {
        return $this->creditProgram;
    }

    public function setCreditProgram(?CreditProgram $creditProgram): static
    {
        $this->creditProgram = $creditProgram;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getInitialPayment(): ?string
    {
        return $this->initialPayment;
    }

    public function setInitialPayment(string $initialPayment): static
    {
        $this->initialPayment = $initialPayment;

        return $this;
    }

    public function getMonthlyPayment(): ?string
    {
        return $this->monthlyPayment;
    }

    public function setMonthlyPayment(string $monthlyPayment): static
    {
        $this->monthlyPayment = $monthlyPayment;

        return $this;
    }
}
