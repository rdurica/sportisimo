<?php

declare(strict_types=1);

namespace App\Component\Form\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use Nette\Application\Responses\RedirectResponse;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Http\Session;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

class BrandForm extends Component
{
    private ?int $id = null;


    public function __construct(
        private readonly User $user,
        private readonly BrandManager $brandManager,
        private readonly Session $session,
    ) {
        $this->id = $this->session->getSection('form')->get("id");
    }

    public function createComponentBrandForm(): Form
    {
        $form = new Form();
        $form->addText("title", "Název značky")
            ->setRequired("Zadejte prosím název značky")
            ->setMaxLength(50);
        $form->addSubmit("save", "Uložit")
            ->setHtmlAttribute("class", "waves-effect waves-green btn-flat");

        $brand = $this->brandManager->getTable()->get($this->session->getSection('form')->get("id"));
        if ($brand) {
            $form->setDefaults(["title" => $brand->title]);
        }

        $form->onSuccess[] = [$this, "onFormSucceed"];

        return $form;
    }

    public function onFormSucceed(Form $form, ArrayHash $values): RedirectResponse
    {
        try {
            $this->brandManager->save($values->title, $this->user->id, $this->id);
            $this->getPresenter()->flashMessage("Značka {$values->title} uložena");
        } catch (UniqueConstraintViolationException $exception) {
            $this->getPresenter()->flashMessage("Značka {$values->title} již existuje");
        }

        $this->session->getSection('form')->remove("id");
        $this->getPresenter()->redirect("this");
    }

    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->render();
    }
}
