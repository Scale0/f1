<?php

declare(strict_types=1);

namespace App\Service\Race;

use App\Entity\Circuit;
use App\Entity\Race;
use App\Entity\Season;
use App\Service\FactoryInterface;
use Webmozart\Assert\Assert;

final class RaceFactory implements FactoryInterface
{
    /**
     * @param array $parameters[season,location, round, date]
     *
     * @return Race
     */
    public static function create(array $parameters): Race
    {
        Assert::keyExists($parameters, 'season', '%s not injected');
        Assert::keyExists($parameters, 'circuit', '%s not injected');
        Assert::keyExists($parameters, 'round', '%s not injected');
        Assert::keyExists($parameters, 'date', '%s not injected');
        Assert::isInstanceOf($parameters['season'], Season::class);
        Assert::isInstanceOf($parameters['circuit'], Circuit::class);
        Assert::integer($parameters['round']);
        Assert::isInstanceOf($parameters['date'], \DateTime::class);

        $race = new Race();
        $race->setSeason($parameters['season'])
            ->setCircuit($parameters['circuit'])
            ->setRound($parameters['round'])
            ->setDate($parameters['date'])
        ;

        return $race;
    }
}
