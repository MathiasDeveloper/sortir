<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\City;
use Faker\Provider\Address;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // CITIES
        for ($i = 0; $i < 10; $i++) {
            $city = new City();
            $city->setName($faker->city);
            $city->setPostcode(Address::postcode());
            $manager->persist($city);
        }
        $manager->flush();
    }
}
