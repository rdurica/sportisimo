<?php

declare(strict_types=1);

namespace App\Component\Grid\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use App\Util\Paginator;
use JetBrains\PhpStorm\NoReturn;
use Nette\Http\Session;

class BrandGrid extends Component
{
    private ?Paginator $paginator;

    public function __construct(
        private readonly BrandManager $brandManager,
        private readonly Session $session,
    ) {
        $this->paginator = $this->session->getSection('grid')->get("paginator");
        if (!$this->paginator) {
            $paginator = new Paginator();
            $paginator->setPage(1)
                ->setItemsPerPage(1);

            $this->session->getSection('grid')->set("paginator", $paginator);
            $this->paginator = $paginator;
        }
    }


    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->paginator = $this->paginator;
        $this->getTemplate()->data = $this->brandManager->getTable()
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

    public function handlePaginate(int $page)
    {
        $this->actualPage = $page;
        $this->getPresenter()->redrawControl("grid");
    }

    public function handleSetItemsPerPage(int $count)
    {
        $this->paginator->setItemsPerPage($count);
    }
}
