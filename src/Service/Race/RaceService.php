<?php

declare(strict_types=1);

namespace App\Service\Race;

use App\Entity\Circuit;
use App\Message\AddRaceToSeasonMessage;
use App\Repository\RaceRepository;
use Doctrine\Persistence\ManagerRegistry;

final class RaceService
{
    public function createRaceIfNotExisting(ManagerRegistry $manager, AddRaceToSeasonMessage $arts, Circuit $circuit)
    {
        $raceRepository = new RaceRepository($manager);
        $race = $raceRepository->findOneBySeasonAndRound($arts->getSeason(), $arts->getRound());

        if (!$race) {
            $raceInfo = [
                'season' => $arts->getSeason(),
                'circuit' => $circuit,
                'round' => $arts->getRound(),
                'date' => $arts->getDate()
            ];

            $race = RaceFactory::create($raceInfo);
            $manager->getManager()->persist($race);
            $manager->getManager()->flush();

            return $race;
        }
    }
}
