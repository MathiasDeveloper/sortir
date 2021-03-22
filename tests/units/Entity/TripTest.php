<?php

namespace App\Tests\Units\Entity;

use App\Entity\Trip;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class TripTest extends TestCase
{
    private const NAME = 'test';

    public function testGetName()
    {
        $trip = new Trip();
        $trip->setName('test');
        $tripRepository = $this->createMock(ObjectRepository::class);
        $tripRepository->expects($this->any())
            ->method('find')
            ->willReturn($trip);
        $this->assertEquals(self::NAME, $trip->getName());
    }

    public function testIsArchived(): void
    {
        $trip = new Trip();
        $trip->setEndDate(new \DateTime('02/03/2020'));
        $this->assertFalse($trip->isArchived());
    }
}
