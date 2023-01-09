<?php

namespace App\DataFixtures;

use App\Factory\TradeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TradeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TradeFactory::createMany(20);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            MaterialFixtures::class,
        ];
    }
}
