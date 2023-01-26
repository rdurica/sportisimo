<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

abstract class Manager
{
    public function __construct(protected Explorer $db)
    {
    }

    abstract public function getTable(): Selection;
}
