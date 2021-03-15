<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\City;
use App\Entity\Site;
use App\Entity\Place;
use App\Entity\State;
use Cocur\Slugify\Slugify;
use App\Entity\Participant;
use DemoBundle\Enum\StateTypeEnum;
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

        // PARTICIPANTS
        for ($i = 0; $i < 20; $i++) {
            $slugify = new Slugify();
            $firstname = $faker->firstName;
            $lastname = $faker->lastName;
            $name = $slugify->slugify("$firstname $lastname");
            $participant = new Participant();
            $participant->setUsername($name);
            $participant->setLastname($lastname);
            $participant->setFirstname($firstname);
            $participant->setPhone($faker->phoneNumber);
            $participant->setEmail($faker->email);
            $participant->setPassword($this->encoder->encodePassword($participant, 'password'));
            $participant->setAdministrator($faker->boolean());
            $participant->setActive($faker->boolean());
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

        // SITES
        for ($i = 0; $i < 20; $i++) {
            $place = new Site();
            $place->setName($faker->city);
            // $place->setParticipant();
            // $place->addTrip();
            $manager->persist($place);
        }
        $manager->flush();

        // STATES
        $state_created = new State();
        $state_created->setLabel(StateTypeEnum::TYPE_CREATED);
        $manager->persist($state_created);
        $state_opened = new State();
        $state_opened->setLabel(StateTypeEnum::TYPE_OPENED);
        $manager->persist($state_opened);
        $state_closed = new State();
        $state_closed->setLabel(StateTypeEnum::TYPE_CLOSED);
        $manager->persist($state_closed);
        $state_ongoing = new State();
        $state_ongoing->setLabel(StateTypeEnum::TYPE_ONGOING);
        $manager->persist($state_ongoing);
        $state_ended = new State();
        $state_ended->setLabel(StateTypeEnum::TYPE_ENDED);
        $manager->persist($state_ended);
        $state_canceled = new State();
        $state_canceled->setLabel(StateTypeEnum::TYPE_CANCELED);
        $manager->persist($state_canceled);
        $manager->flush();
    }
}
