<?php

namespace App\Service;

use App\Dto\BrandDto;
use App\Dto\CarDto;
use App\Dto\CarWithModelDto;
use App\Dto\ModelDto;
use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Model;

class CarDtoService
{
    public function createCarDto(Car $car): CarDto
    {
        return new CarDto(
            $car->getId(),
            $car->getPrice(),
            $car->getPhoto(),
            $this->createBrandDto($car->getBrand())
        );
    }

    public function createCarDtoWithModel(Car $car): CarWithModelDto
    {
        return new CarWithModelDto(
            $car->getId(),
            $car->getPrice(),
            $car->getPhoto(),
            $this->createBrandDto($car->getBrand()),
            $this->createModelDto($car->getModel())
        );
    }

    public function createBrandDto(Brand $brand): BrandDto
    {
        return new BrandDto($brand->getId(), $brand->getName());
    }

    public function createModelDto(Model $model): ModelDto
    {
        return new ModelDto($model->getId(), $model->getName());
    }
}