<?php


namespace App\Services\Trip;

use App\Entity\Participant;
use App\Services\RegistrationInterface;

/**
 * Class Register
 * @package App\Services
 */
class Register implements RegistrationInterface
{

    public function register(Participant $participant): void
    {

    }

    public function unsubscribe(Participant $participant): void
    {
        // TODO: Implement unsubscribe() method.
    }
}
