<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddRaceToSeasonMessage;
use App\Service\Circuit\CircuitService;
use App\Service\F1ApiServiceInterface;
use App\Service\Location\LocationService;
use App\Service\Race\RaceService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AddRaceToSeasonHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
{
    /**
     * @var LocationService
     */
    private $locationService;

    /** @var CircuitService */
    private $circuitService;

    /** @var RaceService */
    private $raceService;
    public function __construct(
        ManagerRegistry $managerRegistry,
        F1ApiServiceInterface $f1Service,
        LocationService $locationService,
        CircuitService $circuitService,
        RaceService $raceService,
        MessageBusInterface $bus
    ) {
        parent::__construct($managerRegistry, $f1Service, $bus);
        $this->locationService = $locationService;
        $this->circuitService = $circuitService;
        $this->raceService = $raceService;
    }

    public function __invoke(AddRaceToSeasonMessage $arts)
    {
        $location = $this->locationService->createLocationIfNotExisting($arts);
        $circuit = $this->circuitService->createCircuitIfNotExisting($arts, $location);
        $this->raceService->createRaceIfNotExisting($arts, $circuit);
    }
}
