<?php

declare(strict_types=1);

namespace App\Service\Constructor;

use App\Entity\Constructor;
use App\Service\FactoryInterface;
use Webmozart\Assert\Assert;

final class ConstructorFactory implements FactoryInterface
{
    /**
     * @param array $parameters
     *
     * @return Constructor
     */
    public static function create(array $parameters): Constructor
    {
        Assert::keyExists($parameters, 'constructorId', '%s not injected');
        Assert::keyExists($parameters, 'name', '%s not injected');
        Assert::keyExists($parameters, 'nationality', '%s not injected');
        Assert::string($parameters['constructorId']);
        Assert::string($parameters['name']);
        Assert::string($parameters['nationality']);

        $constructor = new Constructor();
        $constructor
            ->setNationality($parameters['nationality'])
            ->setName($parameters['name'])
            ->setConstructorId($parameters['constructorId']);

        return $constructor;
    }
}
