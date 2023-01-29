<?php

declare(strict_types=1);

namespace App\Model\Manager;

use App\Model\Manager;
use DateTime;
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

    public function edit(int $id, string $title, int $userId): void
    {
        $this->getTable()->get($id)->update([
            "title" => $title,
            "updated_by" => $userId,
            "updated_at" => new DateTime(),
        ]);
    }
}
