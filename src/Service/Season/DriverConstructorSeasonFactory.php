<?php

declare(strict_types=1);

namespace App\Service\Season;

use App\Entity\Constructor;
use App\Entity\Driver;
use App\Entity\DriverConstructorSeason;
use App\Entity\Season;
use Webmozart\Assert\Assert;

class DriverConstructorSeasonFactory
{
    public static function create(array $parameters): DriverConstructorSeason
    {
        Assert::keyExists($parameters, 'driver', '%s not injected');
        Assert::keyExists($parameters, 'constructor', '%s not injected');
        Assert::keyExists($parameters, 'season', '%s not injected');
        Assert::isInstanceOf($parameters['driver'], Driver::class);
        Assert::isInstanceOf($parameters['constructor'], Constructor::class);
        Assert::isInstanceOf($parameters['season'], Season::class);
        $DCS = new DriverConstructorSeason();
        $DCS
            ->setDriver($parameters['driver'])
            ->setConstructor($parameters['constructor'])
            ->setSeason($parameters['season']);

        return $DCS;
    }
}
