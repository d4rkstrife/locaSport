<?php

namespace App\DataFixtures;

use App\Factory\CommentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements  DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        CommentFactory::createMany(20);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TradeFixtures::class,
        ];
    }
}
