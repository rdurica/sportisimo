<?php

declare(strict_types=1);

namespace App\Model\Manager;

use App\Model\Manager;
use Nette\Database\Table\Selection;

class UserManager extends Manager
{
    public function getTable(): Selection
    {
        return $this->db->table("user");
    }
}
