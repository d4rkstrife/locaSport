<?php

namespace App\DataFixtures;

use App\Factory\ConversationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConversationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ConversationFactory::createMany(10);
        $manager->flush();
    }
}
