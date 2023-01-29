<?php

declare(strict_types=1);

namespace App\Component\Form\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use JetBrains\PhpStorm\NoReturn;
use Nette\Application\Responses\RedirectResponse;
use Nette\Application\UI\Form;
use Nette\Http\Session;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

class BrandForm extends Component
{
    private ?int $id = null;


    public function __construct(
        private User $user,
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

    #[NoReturn] public function onFormSucceed(Form $form, ArrayHash $values): RedirectResponse
    {
        if ($this->id) {
            $this->brandManager->edit($this->id, $values->title, $this->user->id);
            $this->getPresenter()->flashMessage("Značka {$values->title} úspěšne upravena");
        } else {
            $this->brandManager->add($values->title, $this->user->id);
            $this->getPresenter()->flashMessage("Značka {$values->title} úspěšne přidána");
        }

        $this->session->getSection('form')->set("id", null);
        $this->getPresenter()->redirect("this");
    }

    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->render();
    }
}
