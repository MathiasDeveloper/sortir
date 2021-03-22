<?php

namespace App\Tests;

use App\Entity\Trip;
use PHPUnit\Framework\TestCase;

class TripTest extends TestCase
{
    public function testIsArchived(): void
    {
        $trip = new Trip();
        $trip->setEndDate(new \DateTime('02/03/2020'));
        $this->assertFalse($trip->isArchived());
    }
}
