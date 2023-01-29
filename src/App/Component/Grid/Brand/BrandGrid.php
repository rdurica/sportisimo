<?php

declare(strict_types=1);

namespace App\Component\Grid\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use App\Util\Paginator;
use App\Util\Sorter;
use App\Util\SortingType;
use App\Util\Sportisimo;
use Nette\Http\Session;

class BrandGrid extends Component
{
    private ?Paginator $paginator;
    private ?Sorter $sorter;

    public function __construct(
        private readonly BrandManager $brandManager,
        private readonly Session $session
    ) {
        $this->paginator = $this->session->getSection(Sportisimo::SESSION_GRID)->get(Sportisimo::SECTION_PAGINATOR);
        $this->sorter = $this->session->getSection(Sportisimo::SESSION_GRID)->get(Sportisimo::SECTION_SORTER);
        if (!$this->paginator) {
            $paginator = new Paginator();
            $paginator->setTotalItems((int)ceil($this->brandManager->getTable()->count()));

            $this->session->getSection(Sportisimo::SESSION_GRID)->set(Sportisimo::SECTION_PAGINATOR, $paginator);
            $this->paginator = $paginator;
        }
        if (!$this->sorter) {
            $this->sorter = new Sorter();
            $this->session->getSection(Sportisimo::SESSION_GRID)->set(Sportisimo::SECTION_SORTER, $this->sorter);
        }
    }

    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->paginator = $this->paginator;
        $this->paginator->setTotalItems($this->brandManager->getTable()->count());
        $totalPages = $this->paginator->getTotalPages();
        $this->getTemplate()->data = $this->brandManager->getTable()
            ->order("title {$this->sorter->getSorting()}")
            ->page(
                $this->paginator->getPage(),
                $this->paginator->getItemsPerPage(),
                $totalPages,
            );
        $this->savePaginator();
        $this->getTemplate()->render();
    }

    /**
     * Save paginator into session
     */
    private function savePaginator(): void
    {
        $this->session->getSection(Sportisimo::SESSION_GRID)->set(Sportisimo::SECTION_PAGINATOR, $this->paginator);
    }

    /**
     * Delete brand
     */
    public function handleDelete(int $id): void
    {
        $this->brandManager->deleteById($id);
        $this->redrawControl();
    }

    /**
     * Set items per page for grid
     */
    public function handleSetItemsPerPage(int $count): void
    {
        $this->paginator->setItemsPerPage($count);
        $this->savePaginator();
        $this->redrawControl();
    }

    /**
     * Paginate trough pages
     */
    public function handleSetPage(int $page): void
    {
        $this->paginator->setPage($page);
        $this->savePaginator();
        $this->redrawControl();
    }

    /**
     * Paginate to next page
     */
    public function handleSetNext(): void
    {
        if (!$this->paginator->isLastPage()) {
            $this->paginator->setPage($this->paginator->getPage() + 1);
            $this->savePaginator();
            $this->redrawControl();
        }
    }

    /**
     * Paginate to previous page
     */
    public function handleSetPrevious(): void
    {
        if (!$this->paginator->isFirstPage()) {
            $this->paginator->setPage($this->paginator->getPage() - 1);
            $this->savePaginator();
            $this->redrawControl();
        }
    }

    /**
     * Set sorting order based on title
     */
    public function handleSort(string $sortType): void
    {
        switch ($sortType) {
            case SortingType::ASC->name:
                $this->sorter->setSorting(SortingType::ASC);
                break;
            case SortingType::DESC->name:
                $this->sorter->setSorting(SortingType::DESC);
                break;
        }

        $this->redrawControl();
    }
}
