<?php

declare(strict_types=1);

namespace App\Util;

class Paginator
{
    /**
     * Available options (Total items per page)
     */
    private array $itemsPerPageOption = [10, 20, 30];
    private ?int $totalItems;


    public function __construct(private int $page = 1, private int $itemsPerPage = 10)
    {
    }

    public function getItemsPerPage(): ?int
    {
        return $this->itemsPerPage;
    }

    /**
     * Set items per page and reset actual page to 1
     */
    public function setItemsPerPage(int $itemsPerPage): Paginator
    {
        $this->itemsPerPage = $itemsPerPage;
        $this->page = 1;

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

    /**
     * Prepare array of pages which will be rendered
     */
    public function getPaginatorOptions(): array
    {
        $allPages = range(1, $this->getTotalPages());
        $currentPage = $this->getPage();
        $totalPages = $this->getTotalPages();

        if ($totalPages <= 5) {
            return $allPages;
        } elseif ($currentPage <= 3) {
            return array_merge(array_slice($allPages, 0, 5), ["...", $totalPages]);
        } elseif ($currentPage + 2 >= $totalPages) {
            return array_merge([1, "..."], array_slice($allPages, -5, 5));
        } else {
            return array_merge([1, "..."], array_slice($allPages, $currentPage - 2, 4), ["...", $totalPages]);
        }
    }

    public function getTotalPages(): int
    {
        return intval(ceil($this->totalItems / $this->itemsPerPage));
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): Paginator
    {
        $this->page = $page;

        return $this;
    }

    public function isLastPage(): bool
    {
        return ($this->page === $this->getTotalPages());
    }

    public function isFirstPage(): bool
    {
        return ($this->page === 1);
    }
}
