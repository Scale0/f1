<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddRaceToSeasonMessage;
use App\Service\Circuit\CircuitService;
use App\Service\F1ServiceInterface;
use App\Service\Location\LocationService;
use App\Service\Race\RaceService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddRaceToSeasonHandler implements MessageHandlerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var F1ServiceInterface
     */
    private $f1Service;

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
        F1ServiceInterface $f1Service,
        LocationService $locationService,
        CircuitService $circuitService,
        RaceService $raceService
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->f1Service = $f1Service;
        $this->locationService = $locationService;
        $this->circuitService = $circuitService;
        $this->raceService = $raceService;
    }

    public function __invoke(AddRaceToSeasonMessage $arts)
    {
        $location = $this->locationService->createLocationIfNotExisting($this->managerRegistry, $arts);
        $circuit = $this->circuitService->createCircuitIfNotExisting($this->managerRegistry, $arts, $location);
        $this->raceService->createRaceIfNotExisting($this->managerRegistry, $arts, $circuit);
    }
}
