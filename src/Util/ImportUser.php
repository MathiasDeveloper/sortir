<?php

namespace App\Util;

use App\Entity\Participant;
use Symfony\Component\Console\Input\InputInterface;

class ImportUser
{
    use FileUtil;

    public ?array $data;

    public function __construct($filePath)
    {
        if ($this->exist($filePath) && $this->isValid($filePath) && $this->hasValidParticipantHeader($filePath)) {
            $this->data = $this->readCsvToArray($filePath);
        } else {
            $this->data = null;
        }
    }

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
