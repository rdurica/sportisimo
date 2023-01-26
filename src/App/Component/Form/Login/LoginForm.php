<?php

declare(strict_types=1);

namespace App\Component\Form\Login;

use App\Component\Component;
use App\Exception\AccountException;
use App\Model\Service\AuthenticatorService;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

final class LoginForm extends Component
{
    public function __construct(
        private readonly User $user,
        private readonly AuthenticatorService $authenticator
    ) {
    }

    public function createComponentLoginForm(): Form
    {
        $form = new Form();
        $form->addText("username", "Uživatelské jméno")
            ->setRequired()
            ->setHtmlAttribute("class", "form-control")->setHtmlAttribute("id", "floatingInput");
        $form->addPassword("password", "Heslo")
            ->setRequired()
            ->setHtmlAttribute("class", "form-control");
        $form->addSubmit("login", "Pŕihlásit")
            ->setHtmlAttribute("class", "w-100 btn btn-lg btn-primary");

        $form->onSuccess[] = [$this, "formSucceeded"];

        return $form;
    }

    public function formSucceeded(Form $form, ArrayHash $values): void
    {
        try {
            $userIdentity = $this->authenticator->authenticate($values->username, $values->password);
            $this->user->login($userIdentity);
            $this->getPresenter()->flashMessage("OK", "success");
            $this->getPresenter()->redirect("Homepage:");
        } catch (AccountException $ex) {
            $this->getPresenter()->flashMessage(
                $ex->getMessage(),
                "danger"
            );
            $this->redirect("this");
        }
    }


    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->render();
    }
}
