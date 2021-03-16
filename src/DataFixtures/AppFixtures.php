<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\City;
use App\Entity\Site;
use App\Entity\Trip;
use App\Entity\Place;
use Cocur\Slugify\Slugify;
use App\Entity\Participant;
use App\Enum\StateTypeEnum;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // SITES
        for ($i = 0; $i < 20; $i++) {
            $place = new Site();
            $place->setName($faker->city);
            // $place->setParticipant();
            // $place->addTrip();
            $manager->persist($place);
        }
        $manager->flush();

        // PARTICIPANTS
        for ($i = 0; $i < 20; $i++) {
            $slugify = new Slugify();
            $firstname = $faker->firstName;
            $lastname = $faker->lastName;
            $name = $slugify->slugify("$firstname $lastname");

            $sites = $this->entityManager->getRepository(Site::class)->findAll();
            shuffle($sites);
            $site = $sites[0];

            $participant = new Participant();
            $participant->setUsername($name);
            $participant->setLastname($lastname);
            $participant->setFirstname($firstname);
            $participant->setPhone($faker->phoneNumber);
            $participant->setEmail($faker->email);
            $participant->setPassword($this->encoder->encodePassword($participant, 'password'));
            $participant->setAdministrator($faker->boolean());
            $participant->setActive($faker->boolean());
            $participant->setRoles(['ROLE_USER']);
            $participant->setRegistrationDate($faker->dateTimeBetween('-2 week', '-1 day'));
            $participant->setSite($site);
            $manager->persist($participant);
        }
        $manager->flush();

        // CITIES
        for ($i = 0; $i < 10; $i++) {
            $city = new City();
            $city->setName($faker->city);
            $city->setPostcode($faker->postcode);
            $manager->persist($city);
        }
        $manager->flush();

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
            $endDate = $beginDate->modify('+5 week');
            $trip = new Trip();
            $trip->setName($faker->words(2, true));
            $trip->setBeginDate($beginDate);
            $trip->setEndDate($endDate);
            $trip->setDuration($faker->numberBetween(10, 100));
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
    }
}
