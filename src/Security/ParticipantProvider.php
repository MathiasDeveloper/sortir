<?php

namespace App\Security;


use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class ParticipantProvider
 * @package App\Security
 */
class ParticipantProvider implements UserProviderInterface, PasswordUpgraderInterface
{

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        throw new \Exception('TODO: fill in upgradePassword() inside '. __FILE__);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function loadUserByUsername(string $username)
    {
        throw new \Exception('TODO: fill in loadUserByUsername() inside '. __FILE__);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User){
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }
        throw new \Exception('TODO: fill in refreshUser() inside '.__FILE__);
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        // TODO: Implement supportsClass() method.
    }
}
