<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Site;
use App\Entity\Trip;
use App\Entity\Place;
use App\Entity\Participant;
use App\Enums\StateTypeEnum;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TripFixtures extends Fixture implements DependentFixtureInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // TRIPS
        for ($i = 0; $i < 20; $i++) {
            $places = $this->entityManager->getRepository(Place::class)->findAll();
            shuffle($places);
            $place = $places[0];

            $sites = $this->entityManager->getRepository(Site::class)->findAll();
            shuffle($sites);
            $site = $sites[0];

            $states = StateTypeEnum::getAvailableTypes();
            shuffle($states);
            $state = $states[0];

            $organisers = $this->entityManager->getRepository(Participant::class)->findAll();
            shuffle($organisers);
            $organiser = $organisers[0];

            $participants = $this->entityManager->getRepository(Participant::class)->findAll();
            shuffle($participants);

            $beginDate = $faker->dateTimeBetween('-1 week', '+1 week');
            $endDate = $faker->dateTimeBetween('+3 week', '+4 week');

            $trip = new Trip();
            $trip->setName($faker->words(2, true));
            $trip->setBeginDate($beginDate);
            $trip->setEndDate($endDate);
            $trip->setDuration($faker->dateTime());
            $trip->setMaxSubscriptions($faker->numberBetween(2, 20));
            $trip->setDescription($faker->paragraphs($faker->numberBetween(2, 6), true));
            $trip->setOrganisor($organiser);
            $trip->setPlace($place);
            $trip->setSite($site);
            $trip->setState($state);

            $trip->addSubscription($participants[0]);
            $trip->addSubscription($participants[1]);
            $trip->addSubscription($participants[3]);

            $manager->persist($trip);
        }
        $manager->flush();

        $organisorCustom = $this->entityManager->getRepository(Participant::class)->findOneBy(['username' => 'secret-party']);
        $tripRepo = $this->entityManager->getRepository(Trip::class);
        $trips = $tripRepo->findAll();
        $trips = array_slice($trips, 0, 3);

        for ($i = 0; $i < sizeof($trips); $i++) {
            $trips[$i]->setOrganisor($organisorCustom);
            $manager->persist($trips[$i]);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlaceFixtures::class,
            SiteFixtures::class,
            ParticipantFixtures::class,
        ];
    }
}
