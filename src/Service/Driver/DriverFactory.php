<?php

declare(strict_types=1);

namespace App\Service\Driver;

use App\Entity\Driver;
use App\Service\FactoryInterface;
use Webmozart\Assert\Assert;

class DriverFactory implements FactoryInterface
{
    public static function create(array $parameters): Driver
    {
        Assert::keyExists($parameters, 'driverId', '%s not injected');
        Assert::keyExists($parameters, 'code', '%s not injected');
        Assert::keyExists($parameters, 'permanentNumber', '%s not injected');
        Assert::keyExists($parameters, 'firstName', '%s not injected');
        Assert::keyExists($parameters, 'lastName', '%s not injected');
        Assert::keyExists($parameters, 'dateOfBirth', '%s not injected');
        Assert::keyExists($parameters, 'nationality', '%s not injected');
        Assert::string($parameters['driverId']);
        Assert::string($parameters['code']);
        Assert::integer($parameters['permanentNumber']);
        Assert::string($parameters['firstName']);
        Assert::string($parameters['lastName']);
        Assert::isInstanceOf($parameters['dateOfBirth'], \DateTime::class);
        Assert::string($parameters['nationality']);
        $driver = new Driver();
        $driver
            ->setDriverId($parameters['driverId'])
            ->setCode($parameters['code'])
            ->setPermanentNumber($parameters['permanentNumber'])
            ->setFirstName($parameters['firstName'])
            ->setLastName($parameters['lastName'])
            ->setDateOfBirth($parameters['dateOfBirth'])
            ->setNationality($parameters['nationality']);

        return $driver;
    }
}
