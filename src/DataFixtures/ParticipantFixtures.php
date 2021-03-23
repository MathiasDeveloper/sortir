<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Site;
use Cocur\Slugify\Slugify;
use App\Entity\Participant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
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
        $faker = Factory::create('fr_FR');

        $slugify = new Slugify();
        $firstname = 'Secret';
        $lastname = 'Party';
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
        $participant->setAdministrator(1);
        $participant->setActive(1);
        $participant->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $participant->setRegistrationDate($faker->dateTimeBetween('-2 week', '-1 day'));
        $participant->setSite($site);
        $participant->setPhotoUrl("https://eu.ui-avatars.com/api/?name=$name");
        $manager->persist($participant);

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
            $participant->setAdministrator($faker->boolean(20));
            $participant->setActive($faker->boolean());
            $participant->setRoles(['ROLE_USER']);
            $participant->setRegistrationDate($faker->dateTimeBetween('-2 week', '-1 day'));
            $participant->setSite($site);
            $participant->setPhotoUrl("https://eu.ui-avatars.com/api/?name=$name");
            $manager->persist($participant);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SiteFixtures::class,
        ];
    }
}
