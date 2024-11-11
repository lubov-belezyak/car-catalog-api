<?php

namespace App\DataFixtures;

use App\Entity\CreditProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreditProgramFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $expensiveCarProgram = new CreditProgram();
        $expensiveCarProgram->setTitle('Expensive Car');
        $expensiveCarProgram->setInterestRate(15);
        $expensiveCarProgram->setMinPrice(2000000);
        $expensiveCarProgram->setConditions('Кредитная программа для машин, стоимость которых от 2 000 000. Процентная ставка 15%');
        $manager->persist($expensiveCarProgram);

        $initialPaymentProgram = new CreditProgram();
        $initialPaymentProgram->setTitle('Initial Payment');
        $initialPaymentProgram->setInterestRate(11);
        $initialPaymentProgram->setMaxLoanTerm(60);
        $initialPaymentProgram->setMinInitialPaymentPercentage(30);
        $initialPaymentProgram->setConditions('Программа для тех, кто внесет первоначальный взнос от 30% от стоимости машины и срок кредита которых не превышает 5 лет (60 месяцев)');
        $manager->persist($initialPaymentProgram);

        $standardProgram = new CreditProgram();
        $standardProgram->setTitle('Standard');
        $standardProgram->setInterestRate(13);
        $standardProgram->setConditions('Стандартная программа авто кредитования');
        $manager->persist($standardProgram);

        $manager->flush();
    }
}
