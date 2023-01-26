<?php

declare(strict_types=1);

namespace App\Util;

class Paginator
{
    private ?int $page;
    private ?int $itemsPerPage;

    private array $itemsPerPageOption = [10, 20, 30];
    private ?int $totalItems;

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(int $page): Paginator
    {
        $this->page = $page;

        return $this;
    }

    public function getItemsPerPage(): ?int
    {
        return $this->itemsPerPage;
    }

    public function setItemsPerPage(int $itemsPerPage): Paginator
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }


    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }


    public function setTotalItems(int $totalItems): Paginator
    {
        $this->totalItems = $totalItems;

        return $this;
    }


    public function getItemsPerPageOption(): array
    {
        return $this->itemsPerPageOption;
    }
}
