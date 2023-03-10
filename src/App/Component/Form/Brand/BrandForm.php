<?php

declare(strict_types=1);

namespace App\Component\Form\Brand;

use App\Component\Component;
use App\Model\Manager\BrandManager;
use App\Util\Sportisimo;
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
        $this->id = $this->session->getSection(Sportisimo::SESSION_FORM)->get(Sportisimo::SECTION_ID);
    }

    public function createComponentBrandForm(): Form
    {
        $form = new Form();
        $form->addText("title", "Název značky")
            ->setRequired("Zadejte prosím název značky")
            ->setMaxLength(50);
        $form->addSubmit("save", "Uložit");

        $brand = $this->brandManager->getTable()->get(
            $this->session->getSection(Sportisimo::SESSION_FORM)->get(Sportisimo::SECTION_ID)
        );
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
            $this->getPresenter()->flashMessage("Značka {$values->title} uložena", Sportisimo::FLASH_SUCCESS);
        } catch (UniqueConstraintViolationException $ex) {
            $this->getPresenter()->flashMessage("Značka {$values->title} již existuje", Sportisimo::FLASH_DANGER);
        }

        $this->session->getSection(Sportisimo::SESSION_FORM)->remove(Sportisimo::SECTION_ID);
        $this->getPresenter()->redirect("this");
    }

    public function render(): void
    {
        $this->getTemplate()->setFile(__DIR__ . "/default.latte");
        $this->getTemplate()->render();
    }
}
