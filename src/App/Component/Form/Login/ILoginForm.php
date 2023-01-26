<?php

declare(strict_types=1);

namespace App\Component\Form\Login;

interface ILoginForm
{
    public function create(): LoginForm;
}
