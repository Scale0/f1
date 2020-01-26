<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddLapToRaceMessage;
use App\Repository\DriverConstructorSeasonRepository;
use App\Repository\RaceRepository;
use App\Service\F1ServiceInterface;
use App\Service\Race\LapFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AddLapToRaceHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
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

    public function __invoke(AddLapToRaceMessage $lapToRaceMessage)
    {
        $race = $this->raceRepository->find($lapToRaceMessage->getRace()->getId());
        $driver = $this->driverConstructorSeasonRepository->find($lapToRaceMessage->getDriver()->getId());
        $parameters = [
            'race' => $race,
            'driver' => $driver,
            'lap' => $lapToRaceMessage->getLap(),
            'position' => $lapToRaceMessage->getPosition(),
            'time' => $lapToRaceMessage->getTime()
        ];
        $lap = LapFactory::create($parameters);

        $this->managerRegistry->getManager()->persist($lap);
        $this->managerRegistry->getManager()->flush();
    }
}
