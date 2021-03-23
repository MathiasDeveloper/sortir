<?php

namespace App\Tests\Integrations;

use App\Entity\Participant;
use App\Entity\Trip;
use App\Exception\InvalidArgumentException;
use App\Services\Trip\Register;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @var Trip $trip
     */
    private $trip;

    /**
     * @var Participant $participant
     */
    private $participant;

    protected function setUp(): void
    {
        $this->trip = new Trip();
        $this->participant = new Participant();
    }

    public function testRegister(): void
    {
        $participantRepository = $this->createMock(ObjectRepository::class);
        $participantRepository->expects($this->any())->method('find')->willReturn($this->participant);
        $tripRepository = $this->createMock(ObjectRepository::class);
        $tripRepository->expects($this->any())->method('find')->willReturn($this->trip);
        try {
            Register::subscribe($this->participant, $this->trip);
        } catch (OptimisticLockException $e) {
            $e->getMessage();
        } catch (ORMException $e) {
            $e->getMessage();
        } catch (InvalidArgumentException $e) {
            $e->getMessage();
        }
        $this->assertTrue(in_array($this->trip, $this->participant->getSubscriptions()->getValues()));
    }
}
