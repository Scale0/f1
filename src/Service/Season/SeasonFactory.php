<?php

declare(strict_types=1);

namespace App\Service\Season;

use App\Entity\Season;
use Webmozart\Assert\Assert;

final class SeasonFactory
{
    static public function create($parameters) : Season
    {
        Assert::keyExists($parameters, 'year', 'year doesnt exist');
        $season = new Season();
        $season->setYear(intval($parameters['year']));
        return $season;
    }
}
