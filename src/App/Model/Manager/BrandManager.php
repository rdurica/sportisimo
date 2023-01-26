<?php

declare(strict_types=1);

namespace App\Model\Manager;

use App\Model\Manager;
use Nette\Database\Table\Selection;

class BrandManager extends Manager
{
    public function deleteById(int $id): void
    {
        $this->getTable()->where("id", $id)->delete();
    }

    public function getTable(): Selection
    {
        return $this->db->table("brand");
    }

    public function add(string $title, int $userId): void
    {
        $this->getTable()->insert([
            "title" => $title,
            "created_by" => $userId,
        ]);
    }
}
