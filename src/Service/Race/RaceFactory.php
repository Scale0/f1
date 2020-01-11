<?php

declare(strict_types=1);

namespace App\Service\Race;

use App\Entity\Race;
use Webmozart\Assert\Assert;

final class RaceFactory
{
    /**
     * @param array $parameters[season,location, round, date]
     *
     * @return Race
     */
    public static function create(array $parameters): Race
    {
        Assert::keyExists($parameters, 'season', 'season not injected');
        Assert::keyExists($parameters, 'circuit', 'Circuit not injected');
        Assert::keyExists($parameters, 'round', 'Round not injected');
        Assert::keyExists($parameters, 'date', 'Date not injected');

        $race = new Race();
        $race->setSeason($parameters['season'])
            ->setCircuit($parameters['circuit'])
            ->setRound($parameters['round'])
            ->setDate($parameters['date'])
        ;

        return $race;
    }
}
