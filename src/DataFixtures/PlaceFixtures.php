<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\City;
use App\Entity\Place;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PlaceFixtures extends Fixture
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // PLACES
        for ($i = 0; $i < 20; $i++) {
            $cities = $this->entityManager->getRepository(City::class)->findAll();
            shuffle($cities);
            $city = $cities[0];

            $place = new Place();
            $place->setName($faker->streetName);
            $place->setStreet($faker->streetAddress);
            $place->setLat($faker->latitude);
            $place->setLon($faker->longitude);
            $place->setCity($city);
            $manager->persist($place);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CityFixtures::class,
        ];
    }
}
