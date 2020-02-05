<?php

declare(strict_types=1);

namespace App\Service\Circuit;

use App\Entity\Location;
use App\Message\AddRaceToSeasonMessage;
use App\Repository\CircuitRepository;
use Doctrine\Persistence\ManagerRegistry;

class CircuitService
{
    /** @var CircuitRepository */
    private $circuitRepo;
    public function __construct(ManagerRegistry $manager)
    {
        /** @var CircuitRepository $circuitRepo */
        $this->circuitRepo = new CircuitRepository($manager);
    }
    public function createCircuitIfNotExisting(AddRaceToSeasonMessage $arts, Location $location)
    {
        $circuit = $this->circuitRepo->findOneByCircuitId($arts->getCircuitId());
        if (!$circuit) {
            $circuitInfo = [
                'name' => $arts->getCircuitName(),
                'circuitId' => $arts->getCircuitId(),
                'location' => $location
            ];
            $circuit = CircuitFactory::create($circuitInfo);
            $manager->getManager()->persist($circuit);
            $manager->getManager()->flush();
        }

        return $circuit;
    }

    public function getCircuitByName(String $name) {
        return $this->circuitRepo->findOneBy(['name' => $name]);
    }
}
