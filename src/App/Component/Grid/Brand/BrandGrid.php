<?php

declare(strict_types=1);

namespace App\Component\Grid\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use JetBrains\PhpStorm\NoReturn;

class BrandGrid extends Component
{
    public function __construct(
        private readonly BrandManager $brandManager
    ) {
    }


    public function render(): void
    {
        $itemsPerPage = 10;
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->data = $this->brandManager->getTable()
            ->page(
                1,
                10,
                $itemsPerPage
            );
        $this->getTemplate()->render();
    }

    #[NoReturn] public function handleDelete(int $id, string $title)
    {
        $this->brandManager->deleteById($id);
    }

    public function handlePaginate(int $page)
    {
        $this->actualPage = $page;
        $this->getPresenter()->redrawControl("grid");
    }
}
