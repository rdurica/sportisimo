<?php

declare(strict_types=1);

namespace App\Presenter;

use Nette\Application\UI\Presenter;

abstract class SecurePresenter extends Presenter
{
    protected function startup(): void
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect("Auth:Login");
        }
    }
}
