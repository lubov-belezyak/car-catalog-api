<?php

namespace App\Dto;

class CarWithModelDto
{
    private int $id;
    private float $price;
    private string $photo;
    private BrandDto $brand;
    private ModelDto $model;

    public function __construct(int $id, float $price, string $photo, BrandDto $brand, ModelDto $model)
    {
        $this->id = $id;
        $this->price = $price;
        $this->photo = $photo;
        $this->brand = $brand;
        $this->model = $model;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getBrand(): BrandDto
    {
        return $this->brand;
    }

    public function getModel(): ModelDto
    {
        return $this->model;
    }
}