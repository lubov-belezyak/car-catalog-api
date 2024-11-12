<?php

namespace App\Entity;

use App\Repository\CreditProgramRepository;
use App\Request\CalculateCreditProgramRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditProgramRepository::class)]
class CreditProgram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 512)]
    private ?string $conditions = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1, options: ['unsigned' => true])]
    private ?float $interestRate = null;

    #[ORM\Column(nullable: true)]
    private ?int $minPrice = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxPrice = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxLoanTerm = null;

    #[ORM\Column(nullable: true)]
    private ?int $minInitialPaymentPercentage = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxInitialPaymentPercentage = null;

    /**
     * @var Collection<int, Application>
     */
    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'creditProgram')]
    private Collection $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getConditions(): ?string
    {
        return $this->conditions;
    }

    public function setConditions(string $conditions): static
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(float $interestRate): static
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    public function setMinPrice(?int $minPrice): static
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?int $maxPrice): static
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function getMaxLoanTerm(): ?int
    {
        return $this->maxLoanTerm;
    }

    public function setMaxLoanTerm(?int $maxLoanTerm): static
    {
        $this->maxLoanTerm = $maxLoanTerm;

        return $this;
    }

    public function getMinInitialPaymentPercentage(): ?int
    {
        return $this->minInitialPaymentPercentage;
    }

    public function setMinInitialPaymentPercentage(?int $minInitialPaymentPercentage): static
    {
        $this->minInitialPaymentPercentage = $minInitialPaymentPercentage;

        return $this;
    }

    public function getMaxInitialPaymentPercentage(): ?int
    {
        return $this->maxInitialPaymentPercentage;
    }

    public function setMaxInitialPaymentPercentage(?int $maxInitialPaymentPercentage): static
    {
        $this->maxInitialPaymentPercentage = $maxInitialPaymentPercentage;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setCreditProgram($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getCreditProgram() === $this) {
                $application->setCreditProgram(null);
            }
        }

        return $this;
    }
}
