<?php

declare(strict_types=1);

namespace App\Util;

class Sorter
{
    private string $sorting = "ASC";

    public function getSorting(): string
    {
        return $this->sorting;
    }

    public function setSorting(SortingType $sortType): Sorter
    {
        $this->sorting = $sortType->name;

        return $this;
    }
}
