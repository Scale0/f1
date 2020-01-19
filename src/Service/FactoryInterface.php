<?php

declare(strict_types=1);

namespace App\Service;

interface FactoryInterface
{
    public static function create(array $parameters);
}
