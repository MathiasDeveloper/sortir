<?php

namespace App\Tests\Units\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CityTest extends KernelTestCase
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
    }

}
