<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Site;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SiteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // SITES
        for ($i = 0; $i < 20; $i++) {
            $site = new Site();
            $site->setName($faker->city);
            $manager->persist($site);
        }
        $manager->flush();
    }
}
