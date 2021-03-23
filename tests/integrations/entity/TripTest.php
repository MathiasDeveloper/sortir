<?php

namespace App\Tests\Integrations\Entity;

use App\Entity\Trip;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TripTest extends KernelTestCase
{

    /**
     * @var EntityManagerInterface $entityManager
     */
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $$this->entityManager->getRepository();
    }

    public function testIsArchived(): void
    {
        $trip = new Trip();
        $trip->setEndDate(new \DateTime('02/03/2020'));
        $this->assertFalse($trip->isArchived());
    }
}
