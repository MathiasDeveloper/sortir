<?php

namespace App\Tests\Integrations;

use App\Entity\Participant;
use App\Entity\Trip;
use App\Exception\InvalidArgumentException;
use App\Services\Trip\Register;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class RegisterTest extends KernelTestCase
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testRegister(): void
    {
        /** @var Trip $trip */
        $trip = $this->entityManager->getRepository(Trip::class)->find(1);
        /** @var Participant $participant */
        $participant = $this->entityManager->getRepository(Participant::class)->find(2);
        try {
            Register::subscribe($participant, $trip);
            $this->entityManager->flush();
        } catch (OptimisticLockException $e) {
            $e->getMessage();
        } catch (ORMException $e) {
            $e->getMessage();
        } catch (InvalidArgumentException $e) {
            $e->getMessage();
        }
        $this->assertTrue(in_array($trip, $participant->getSubscriptions()->getValues()));
    }
}
