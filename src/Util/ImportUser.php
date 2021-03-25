<?php

namespace App\Util;

use App\Entity\Participant;
use App\Exception\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportUser
 * @package App\Util
 */
class ImportUser
{
    use FileUtil;

    /**
     * @var array|null
     */
    public ?array $data;


    /**
     * ImportUser constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        try {
            $this->exist($filePath);
            $this->isValid($filePath);
            $this->hasValidParticipantHeader($filePath);
            $this->data = $this->readCsvToArray($filePath);
        } catch (Exception $exception) {
            Logger::getInstance()->error($exception->getMessage());
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function import(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        foreach ($this->data as $row) {
            $participant = new Participant();
            $participant->setUsername($row['user_name']);
            $participant->setLastname($row['last_name']);
            $participant->setFirstname($row['first_name']);
            $participant->setPhone($row['phone']);
            $participant->setEmail($row['email']);
            $participant->setPassword($row['password']);
            $participant->setAdministrator($row['administrator']);
            $participant->setActive($row['active']);
            $participant->setRoles($row['role']);
            $participant->setRegistrationDate($row['date_registration']);
            $participant->setSite($row['site']);

            $em->persist($participant);
        }

        $em->flush();
        $em->clear();
    }
}
