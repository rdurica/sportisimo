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
            $paginator->setPage(1)
                ->setItemsPerPage(10);

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
        $this->getTemplate()->data = $this->brandManager->getTable()
            ->order("title {$this->sorter->getSorting()}")
            ->page(
                1,
                $this->paginator->getItemsPerPage(),
                $itemsPerPage
            );
        $this->getTemplate()->render();
    }

    #[NoReturn] public function handleDelete(int $id, string $title)
    {
        $this->brandManager->deleteById($id);
    }

    public function handleSetItemsPerPage(int $count)
    {
        $this->paginator->setItemsPerPage($count);
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
