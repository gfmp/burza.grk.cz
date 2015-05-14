<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Security;

use App\Model\ORM\Entity\User;
use App\Model\ORM\Repository\UsersRepository;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Utils\DateTime;

final class Authenticator implements IAuthenticator
{

    /** @var UsersRepository */
    private $repository;

    /**
     * @param UsersRepository $repository
     */
    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Performs an authentication against e.g. database.
     * and returns IIdentity on success or throws AuthenticationException
     *
     * @return IIdentity
     * @throws AuthenticationException
     */

    /**
     * Performs an authentication.
     *
     * @return Identity
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        /** @var User $user */
        $user = $this->repository->getBy(['username' => $username]);

        if (!$user) {
            throw new AuthenticationException('Špatné uživatelské jméno.', self::IDENTITY_NOT_FOUND);
        }

        if (!Passwords::verify($password, $user->password)) {
            throw new AuthenticationException('Špatné heslo', self::INVALID_CREDENTIAL);
        }

        // Update logged date
        $user->loggedAt = new DateTime();
        $this->repository->persistAndFlush($user);

        return $user->toIdentity();
    }
}
