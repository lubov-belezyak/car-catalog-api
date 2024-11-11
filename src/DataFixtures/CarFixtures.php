<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use App\Repository\BrandRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $car = new Car();

            $randomBrand = array_rand(BrandFixtures::BRAND_REFERENCES);
            $randomModel = array_rand(ModelFixtures::MODEL_REFERENCES);


            $car->setBrand($this->getReference(
                BrandFixtures::BRAND_REFERENCES[$randomBrand]
            ));

            $car->setModel($this->getReference(
                ModelFixtures::MODEL_REFERENCES[$randomModel]
            ));

            $car->setPrice(mt_rand(350000, 5000000));
            $car->setPhoto('https://placehold.co/600x400.png');
            $manager->persist($car);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ModelFixtures::class,
            BrandFixtures::class
        ];
    }
}
