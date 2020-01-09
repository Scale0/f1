<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Season;

interface F1ServiceInterface
{
    function addSeason(string $year): void;

    function addRaceScheduleToSeason(Season $season): void;

    function getResultsFromApi($url): array;
}
