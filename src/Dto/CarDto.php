<?php

namespace App\Dto;

/**
 * @OA\Schema(
 *     schema="CarDTO",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="model", type="string"),
 *     @OA\Property(property="price", type="integer")
 * )
 */
class CarDto
{
    private int $id;
    private float $price;
    private string $photo;
    private BrandDto $brand;

    public function __construct(int $id, float $price, string $photo, BrandDto $brand)
    {
        $this->id = $id;
        $this->price = $price;
        $this->photo = $photo;
        $this->brand = $brand;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBrand(): BrandDto
    {
        return $this->brand;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }
}