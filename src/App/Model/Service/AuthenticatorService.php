<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Exception\AccountException;
use App\Model\Manager\UserManager;
use Nette\Security\Authenticator;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;

readonly class AuthenticatorService implements Authenticator
{
    public function __construct(
        private UserManager $userManager,
        private Passwords $passwords
    ) {
    }


    /**
     * @throws AccountException
     */
    public function authenticate(string $user, string $password): SimpleIdentity
    {
        $userEntity = $this->userManager->findUserByUsername($user);
        if (!$userEntity) {
            throw new AccountException("Užívatel nebyl nalezen");
        }

        if ($userEntity->is_active === 0) {
            throw new AccountException("Účet byl zablokován");
        }

        if (!$this->passwords->verify($password, $userEntity->password)) {
            throw new AccountException("Nesprávne heslo");
        }

        return new SimpleIdentity($userEntity->id, roles: [], data: [
            "username" => $userEntity->username,
            "first_name" => $userEntity->first_name,
            "last_name" => $userEntity->last_name,
            "email" => $userEntity->email,
        ]);
    }
}
