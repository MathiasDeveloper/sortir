<?php

namespace App\Services;




use App\Entity\Participant;

interface RegistrationInterface
{
    public function register(Participant $participant): void;
    public function unsubscribe(Participant $participant): void;
}
