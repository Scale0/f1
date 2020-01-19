<?php

declare(strict_types=1);

namespace App\Service\Race;

use App\Entity\RaceResult;
use App\Service\FactoryInterface;
use Webmozart\Assert\Assert;

class RaceResultFactory implements FactoryInterface
{
    public static function create($parameters): RaceResult
    {
        Assert::keyExists($parameters, 'race', '%s not injected');
        Assert::keyExists($parameters, 'driver', '%s not injected');
        Assert::keyExists($parameters, 'status', '%s not injected');
        Assert::keyExists($parameters, 'laps', '%s not injected');
        Assert::keyExists($parameters, 'grid', '%s not injected');
        Assert::keyExists($parameters, 'position', '%s not injected');

        $raceResult = new RaceResult();
        $raceResult
            ->setRace($parameters['race'])
            ->setDriver($parameters['driver'])
            ->setGrid($parameters['grid'])
            ->setPosition($parameters['position'])
            ->setStatus($parameters['status'])
            ->setLaps($parameters['laps'])
        ;

        return $raceResult;
    }
}
