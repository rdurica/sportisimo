<?php

declare(strict_types=1);

namespace App\Presenter;

use App\Component\Form\Brand\BrandForm;
use App\Component\Form\Brand\IBrandForm;
use App\Component\Grid\Brand\BrandGrid;
use App\Component\Grid\Brand\IBrandGrid;
use Nette\Application\UI\Presenter;
use Nette\DI\Attributes\Inject;

final class HomepagePresenter extends Presenter
{
    #[Inject]
    public IBrandGrid $brandGrid;

    #[Inject]
    public IBrandForm $brandForm;


    public function createComponentBrandGrid(): BrandGrid
    {
        return $this->brandGrid->create();
    }

    public function createComponentBrandForm(): BrandForm
    {
        return $this->brandForm->create(null);
    }

    public function renderDefault(): void
    {
    }
}
