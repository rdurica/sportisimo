<?php

declare(strict_types=1);

namespace App\Component\Form\Brand;

interface IBrandForm
{
    public function create(?int $id): BrandForm;
}
