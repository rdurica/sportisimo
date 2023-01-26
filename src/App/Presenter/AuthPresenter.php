<?php

declare(strict_types=1);

namespace App\Presenter;

use App\Component\Form\Login\ILoginForm;
use App\Component\Form\Login\LoginForm;
use Nette\Application\UI\Presenter;
use Nette\DI\Attributes\Inject;

class AuthPresenter extends Presenter
{
    #[Inject]
    public ILoginForm $loginForm;

    protected function startup(): void
    {
        parent::startup();
        if ($this->getUser()->isLoggedIn()) {
            $this->redirect("Homepage:");
        }
        $this->setLayout("authLayout");
    }

    protected function renderLogin()
    {
    }

    protected function createComponentLoginForm(): LoginForm
    {
        return $this->loginForm->create();
    }
}
