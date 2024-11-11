<?php

use App\DataFixtures\BrandFixtures;
use App\DataFixtures\ModelFixtures;
use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

$randomModel = array_rand(ModelFixtures::MODEL_REFERENCES);

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
