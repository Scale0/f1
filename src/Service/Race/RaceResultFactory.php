<?php

declare(strict_types=1);

namespace App\Service\Race;

use App\Entity\DriverConstructorSeason;
use App\Entity\Race;
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
        Assert::keyExists($parameters, 'fastestLap', '%s not injected');
        Assert::keyExists($parameters, 'fastestLapRank', '%s not injected');
        Assert::keyExists($parameters, 'fastestLapTime', '%s not injected');
        Assert::keyExists($parameters, 'avgSpeed', '%s not injected');
        Assert::isInstanceOf($parameters['race'], Race::class);
        Assert::isInstanceOf($parameters['driver'], DriverConstructorSeason::class);
        Assert::string($parameters['status']);
        Assert::integer($parameters['laps']);
        Assert::integer($parameters['grid']);
        Assert::integer($parameters['position']);
        Assert::nullOrInteger($parameters['fastestLap']);
        Assert::nullOrInteger($parameters['fastestLapRank']);
        Assert::nullOrString($parameters['fastestLapTime']);
        Assert::nullOrString($parameters['avgSpeed']);


        $raceResult = new RaceResult();
        $raceResult
            ->setRace($parameters['race'])
            ->setDriver($parameters['driver'])
            ->setGrid($parameters['grid'])
            ->setPosition($parameters['position'])
            ->setStatus($parameters['status'])
            ->setLaps($parameters['laps'])
            ->setFastestLap($parameters['fastestLap'])
            ->setFastestLapRank($parameters['fastestLapRank'])
            ->setFastestLapTime($parameters['fastestLapTime'])
            ->setAvgSpeed($parameters['avgSpeed'])
        ;

        return $raceResult;
    }
}
