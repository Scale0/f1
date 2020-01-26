<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Constructor;
use App\Entity\Race;
use App\Entity\Season;

interface F1ServiceInterface
{
    function addSeason(string $year): void;
    function addRaceScheduleToSeason(Season $season): void;
    function updateConstructors(Season $season): void;
    function updateDrivers(Season $season, Constructor $constructor);
    function getResultsFromApi($url): array;
    function asciiF1Car(): string;
    function updateRaceResults(Race $race): void;
    function addLapsToRace(Race $race, int $lap): void;
}
