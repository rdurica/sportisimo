<?php

declare(strict_types=1);

namespace App\Presenter;

use App\Component\Form\Brand\BrandForm;
use App\Component\Form\Brand\IBrandForm;
use App\Component\Grid\Brand\BrandGrid;
use App\Component\Grid\Brand\IBrandGrid;
use Nette\Application\Responses\RedirectResponse;
use Nette\DI\Attributes\Inject;

final class HomepagePresenter extends SecurePresenter
{
    #[Inject]
    public IBrandGrid $brandGrid;

    #[Inject]
    public IBrandForm $brandForm;


    protected function createComponentBrandGrid(): BrandGrid
    {
        return $this->brandGrid->create();
    }

    protected function createComponentBrandForm(): BrandForm
    {
        return $this->brandForm->create(null);
    }

    protected function renderDefault(): void
    {
    }

    protected function actionLogOut(): RedirectResponse
    {
        $this->getUser()->logout(true);
        $this->redirect("Auth:Login");
    }
}
