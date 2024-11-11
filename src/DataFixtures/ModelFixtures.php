<?php

namespace App\DataFixtures;

use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture
{
    public const MODEL_REFERENCES = ['duster', 'accent', 'corolla', 'x5'];

    public function load(ObjectManager $manager): void
    {
        $modelNames = ['Duster', 'Accent', 'Corolla', 'X5'];

        foreach ($modelNames as $i => $modelName) {
            $model = new Model();
            $model->setName($modelName);
            $manager->persist($model);

            $this->addReference(self::MODEL_REFERENCES[$i], $model);
        }
        $manager->flush();
    }
}
