<?php


namespace App\Services\Trip;

use App\Entity\Participant;
use App\Entity\Trip;
use App\Exception\InvalidArgumentException;
use App\Services\RegistrationInterface;

/**
 * Class Register
 * @package App\Services
 */
class Register implements RegistrationInterface
{

    /**
     * @param Participant $participant
     * @param Trip $trip
     * @throws InvalidArgumentException
     */
    public static function subscribe(Participant &$participant, Trip $trip): void
    {
        if (!self::isValid($participant, $trip)) {
            throw new InvalidArgumentException(sprintf('%s and %s is null', $participant, $trip));
        }
        $participant->addSubscription($trip);
    }

    /**
     * @param Participant $participant
     * @param Trip $trip
     */
    public static function unsubscribe(Participant &$participant, Trip $trip): void
    {
        // TODO: Implement unsubscribe() method.
    }

    /**
     * @param Participant $participant
     * @param Trip $trip
     * @return bool
     */
    public static function isValid(Participant $participant, Trip $trip): bool
    {
        return (null !== $participant || null !== $trip);
    }
}
