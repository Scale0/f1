<?php

declare(strict_types=1);

namespace App\Service\Race;

use App\Entity\DriverConstructorSeason;
use App\Entity\Lap;
use App\Entity\Race;
use App\Service\FactoryInterface;
use Webmozart\Assert\Assert;

class LapFactory implements FactoryInterface
{
    public static function create(array $parameters)
    {
        Assert::keyExists($parameters, 'race', '%s not injected');
        Assert::keyExists($parameters, 'driver', '%s not injected');
        Assert::keyExists($parameters, 'lap', '%s not injected');
        Assert::keyExists($parameters, 'position', '%s not injected');
        Assert::keyExists($parameters, 'time', '%s not injected');
        Assert::isInstanceOf($parameters['race'], Race::class);
        Assert::isInstanceOf($parameters['driver'], DriverConstructorSeason::class);
        Assert::integer($parameters['lap']);
        Assert::integer($parameters['position']);
        Assert::string($parameters['time']);

        $lap = new Lap();
        $lap
            ->setRace($parameters['race'])
            ->setDriver($parameters['driver'])
            ->setLap($parameters['lap'])
            ->setPosition($parameters['position'])
            ->setTime($parameters['time']);

        return $lap;
    }
}
