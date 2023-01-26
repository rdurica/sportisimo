<?php

declare(strict_types=1);

namespace App\Model\Manager;

use App\Model\Manager;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Security\Passwords;

class UserManager extends Manager
{
    public function __construct(protected Explorer $db, private readonly Passwords $passwords)
    {
        parent::__construct($db);
    }

    public function findUserByUsername(string $username): ?ActiveRow
    {
        return $this->getTable()->where("username = ?", $username)->fetch();
    }

    public function getTable(): Selection
    {
        return $this->db->table("user");
    }

    public function createUser(
        string $username,
        string $firstName,
        string $lastName,
        string $email,
        string $plainPassword
    ): void {
        $userEntity = [
            "username" => $username,
            "password" => $this->passwords->hash($plainPassword),
            "first_name" => $firstName,
            "last_name" => $lastName,
            "email" => $email,
        ];

        $this->getTable()->insert($userEntity);
    }
}
