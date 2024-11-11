<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public const BRAND_REFERENCES = ['bmw', 'honda', 'toyota', 'mercedes_benz'];

    public function load(ObjectManager $manager): void
    {
        $brandNames = ['BMW', 'Honda', 'Toyota', 'Mercedes-Benz'];

        foreach ($brandNames as $i => $brandName) {
            $brand = new Brand();
            $brand->setName($brandName);
            $manager->persist($brand);

            $this->addReference(self::BRAND_REFERENCES[$i], $brand);
        }
        $manager->flush();
    }
}
