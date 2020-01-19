<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddResultToRaceMessage;
use App\Repository\DriverConstructorSeasonRepository;
use App\Repository\RaceRepository;
use App\Service\F1ServiceInterface;
use App\Service\Race\RaceResultFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AddResultToRaceHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
{
    /** @var RaceRepository */
    private $raceRepository;
    /** @var DriverConstructorSeasonRepository */
    private $driverConstructorSeasonRepository;

    public function __construct(
        ManagerRegistry $managerRegistry,
        F1ServiceInterface $f1Service,
        MessageBusInterface $bus,
        RaceRepository $raceRepository,
        DriverConstructorSeasonRepository $driverConstructorSeasonRepository
    ) {
        parent::__construct($managerRegistry, $f1Service, $bus);
        $this->raceRepository = $raceRepository;
        $this->driverConstructorSeasonRepository = $driverConstructorSeasonRepository;
    }

    public function __invoke(AddResultToRaceMessage $raceResult){
        $race = $this->raceRepository->find($raceResult->getRace()->getId());
        $driver = $this->driverConstructorSeasonRepository->find($raceResult->getDriver()->getId());

        $result = RaceResultFactory::create(
            [
                'race' => $race,
                'driver' => $driver,
                'position' => $raceResult->getPosition(),
                'status' => $raceResult->getStatus(),
                'laps' => $raceResult->getLaps(),
                'grid' => $raceResult->getGrid(),
                'fastestLap' => $raceResult->getFastestLap(),
                'fastestLapRank' => $raceResult->getFastestLapRank(),
                'fastestLapTime' => $raceResult->getFastestLapTime(),
                'avgSpeed' => $raceResult->getAvgSpeed()
            ]
        );
        $this->managerRegistry->getManager()->persist($result);
        $this->managerRegistry->getManager()->flush();
    }
}
