<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Constructor;
use App\Entity\Season;

interface F1ServiceInterface
{
    public function addSeason(string $year): void;

    public function addRaceScheduleToSeason(Season $season): void;

    function getResultsFromApi($url): array;

    public function updateConstructors(Season $season): void;

    public function updateDrivers(Season $season, Constructor $constructor);
}
