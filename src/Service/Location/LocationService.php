<?php

declare(strict_types=1);

namespace App\Service\Location;

use App\Message\AddRaceToSeasonMessage;
use App\Repository\LocationRepository;
use Doctrine\Persistence\ManagerRegistry;

class LocationService
{
    public function createLocationIfNotExisting(ManagerRegistry $manager, AddRaceToSeasonMessage $arts)
    {
        $locationRepo = new LocationRepository($manager);
        $location = $locationRepo->findOneByLongitudeAndLatitude($arts->getLocationLong(), $arts->getLocationLat());

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
