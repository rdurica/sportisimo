<?php

declare(strict_types=1);

namespace App\Component;

use Nette\Application\UI\Control;

abstract class AbstractComponent extends Control
{
    abstract public function render(): void;
}
