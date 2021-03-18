<?php

namespace App\Services;




use App\Entity\Participant;
use App\Entity\Trip;

interface RegistrationInterface
{
    public static function subscribe(Participant &$participant, Trip $trip): void;
    public static function unsubscribe(Participant &$participant, Trip $trip): void;
    public static function isValid(Participant $participant, Trip $trip): bool;
}
