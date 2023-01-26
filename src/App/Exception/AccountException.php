<?php

declare(strict_types=1);

namespace App\Exception;

class AccountException extends SportisimoException
{
    public function __construct(string $message = "Problém s přihlášením")
    {
        parent::__construct($message);
    }
}
