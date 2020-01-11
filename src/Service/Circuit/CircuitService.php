<?php

declare(strict_types=1);

namespace App\Service\Circuit;

use App\Entity\Location;
use App\Message\AddRaceToSeasonMessage;
use App\Repository\CircuitRepository;
use Doctrine\Persistence\ManagerRegistry;

class CircuitService
{
    public function createCircuitIfNotExisting(ManagerRegistry $manager, AddRaceToSeasonMessage $arts, Location $location)
    {
        /** @var CircuitRepository $circuitRepo */
        $circuitRepo = new CircuitRepository($manager);
        $circuit = $circuitRepo->findOneByCircuitId($arts->getCircuitId());
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
}
