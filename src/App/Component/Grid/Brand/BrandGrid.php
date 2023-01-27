<?php

declare(strict_types=1);

namespace App\Component\Grid\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use App\Util\Paginator;
use App\Util\Sorter;
use App\Util\SortingType;
use JetBrains\PhpStorm\NoReturn;
use Nette\Http\Session;

class BrandGrid extends Component
{
    private ?Paginator $paginator;

    private ?Sorter $sorter;

    public function __construct(
        private readonly BrandManager $brandManager,
        private readonly Session $session,
    ) {
        $this->paginator = $this->session->getSection('grid')->get("paginator");
        $this->sorter = $this->session->getSection('grid')->get("sorter");
        if (!$this->paginator) {
            $paginator = new Paginator();
            $paginator->setTotalItems((int)ceil($this->brandManager->getTable()->count()));

            $this->session->getSection('grid')->set("paginator", $paginator);
            $this->paginator = $paginator;
        }
        if (!$this->sorter) {
            $this->sorter = new Sorter();
            $this->session->getSection('grid')->set("sorter", $this->sorter);
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

    private function savePaginator()
    {
        $this->session->getSection('grid')->set("paginator", $this->paginator);
    }

    #[NoReturn] public function handleDelete(int $id, string $title)
    {
        $this->brandManager->deleteById($id);
    }

    public function handleSetItemsPerPage(int $count)
    {
        $this->paginator->setItemsPerPage($count);
        $this->savePaginator();
    }

    public function handleSetPage(int $page)
    {
        $this->paginator->setPage($page);
        $this->savePaginator();
    }

    public function handleSetNext()
    {
        $this->paginator->setPage($this->paginator->getPage() + 1);
        $this->savePaginator();
        $this->getPresenter()->redirect("this");
    }

    public function handleSetPrevious()
    {
        $this->paginator->setPage($this->paginator->getPage() - 1);
        $this->savePaginator();
        $this->getPresenter()->redirect("this");
    }

    public function handleSortASC()
    {
        $this->sorter->setSorting(SortingType::ASC);
    }

    public function handleSortDESC()
    {
        $this->sorter->setSorting(SortingType::DESC);
    }
}
