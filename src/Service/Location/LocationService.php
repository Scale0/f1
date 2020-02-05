<?php

declare(strict_types=1);

namespace App\Service\Location;

use App\Message\AddRaceToSeasonMessage;
use App\Repository\LocationRepository;
use Doctrine\Persistence\ManagerRegistry;

class LocationService
{
    /** @var LocationRepository */
    private $locationRepo;
    public function __construct(ManagerRegistry $manager)
    {
        /** @var LocationRepository $circuitRepo */
        $this->locationRepo = new LocationRepository($manager);
    }

    public function createLocationIfNotExisting(AddRaceToSeasonMessage $arts)
    {
        $location = $this->locationRepo->findOneByLongitudeAndLatitude($arts->getLocationLong(), $arts->getLocationLat());

        if (!$location) {
            $locationInfo = [
                'country' => $arts->getLocationCountry(),
                'longitude' => $arts->getLocationLong(),
                'latitude' => $arts->getLocationLat(),
                'locality' => $arts->getLocationLocality()
            ];
            $location = LocationFactory::create($locationInfo);
            $manager->getManager()->persist($location);
            $manager->getManager()->flush();
        }

        return $location;
    }
}
