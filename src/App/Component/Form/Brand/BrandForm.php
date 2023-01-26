<?php

declare(strict_types=1);

namespace App\Component\Form\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use Nette\Application\Responses\RedirectResponse;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class BrandForm extends Component
{
    public function __construct(public ?int $id, private readonly BrandManager $brandManager)
    {
    }

    public function createComponentBrandForm(): Form
    {
        $form = new Form();
        $form->addHidden("id", $this->id);
        $form->addText("title", "Název značky")
            ->setRequired("Zadejte prosím název značky")
            ->setMaxLength(50);
        $form->addSubmit("save", "Uložit")
            ->setHtmlAttribute("class", "waves-effect waves-green btn-flat");

        $form->onSuccess[] = [$this, "onFormSucceed"];

        return $form;
    }

    public function onFormSucceed(Form $form, ArrayHash $values): RedirectResponse
    {
        $this->brandManager->add($values->title);
        $this->getPresenter()->flashMessage("Značka {$values->title} úspěšne přidána");
        $this->getPresenter()->redirect("this");
    }

    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->render();
    }
}
