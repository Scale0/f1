<?php

declare(strict_types=1);

namespace App\Service\Race;

use App\Entity\Circuit;
use App\Entity\ScheduledMessage;
use App\Message\AddRaceResultsToRaceMessage;
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

            /* toevoegen van de race aan de scheduled messages, eerst moet er een message gemaakt worden die race resultaten gaat ophalen. */
            $scheduledMessage = new ScheduledMessage();
            $scheduledMessage->setMessage(AddRaceResultsToRaceMessage::class);
            $scheduledMessage->setScheduled($arts->getDate()->modify('+ 1 day'));
            $scheduledMessage->setParameters(['race' => $race]);
            $manager->getManager()->persist($scheduledMessage);

            $manager->getManager()->flush();

            return $race;
        }
    }
}
