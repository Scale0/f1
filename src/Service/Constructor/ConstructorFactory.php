<?php

declare(strict_types=1);

namespace App\Service\Constructor;

use App\Entity\Constructor;
use Webmozart\Assert\Assert;

final class ConstructorFactory
{
    /**
     * @param array $parameters
     *
     * @return Constructor
     */
    public static function create(array $parameters): Constructor
    {
        Assert::keyExists($parameters, 'constructorId', 'ConstructorId not injected');
        Assert::keyExists($parameters, 'name', 'Name not injected');
        Assert::keyExists($parameters, 'nationality', 'Nationality not injected');

        $constructor = new Constructor();
        $constructor
            ->setNationality($parameters['nationality'])
            ->setName($parameters['name'])
            ->setConstructorId($parameters['constructorId']);

        return $constructor;
    }
}
