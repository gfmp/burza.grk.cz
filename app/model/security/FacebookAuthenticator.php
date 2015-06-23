<?php

/**
 * @package burza.grk.cz
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @version $$REV$$
 */

namespace App\Model\Security;

use App\Model\ORM\Entity\User;
use App\Model\ORM\Repository\UsersRepository;
use Facebook\GraphObject;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\Passwords;
use Nette\Utils\DateTime;

final class FacebookAuthenticator implements IAuthenticator
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
     * Performs an authentication.
     *
     * @return Identity
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        /** @var GraphObject $me */
        list($me) = $credentials;

        $fbid = $me->getProperty('id');
        $email = $me->getProperty('email');

        if (!$fbid || !$email) {
            throw new AuthenticationException('Registrace proběhla neúspěšně. Prosím registrujte se ručně.', self::FAILURE);
        }

        // Exists user with this FBID?
        $user = $this->repository->getBy(['fbid' => $fbid]);
        if ($user) {
            return $user->toIdentity();
        }

        // Exists user with this USERNAME?
        $user = $this->repository->getBy(['username' => $email]);
        if ($user) {
            try {
                // Update fbid
                $user->fbid = $fbid;
                $user->loggedAt = new DateTime();

                // Save user
                $this->repository->persistAndFlush($user);
            } catch (\PDOException $e) {
                throw new AuthenticationException('Registrace proběhla neúspěšně. Prosím zkuste to za chvíli.', self::FAILURE);
            }
        } else {
            try {
                $user = new User();
                $user->setRawValue('fbid', $fbid);
                $user->username = $email;
                $user->password = Passwords::hash(time() . $me->getProperty('id'));
                $user->loggedAt = new DateTime();

                // Save user
                $this->repository->persistAndFlush($user);
            } catch (\PDOException $e) {
                throw new AuthenticationException('Registrace proběhla neúspěšně. Prosím zkuste to za chvíli.', self::FAILURE);
            }
        }

        return $user->toIdentity();
    }
}
