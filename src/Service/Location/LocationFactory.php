<?php

declare(strict_types=1);

namespace App\Service\Location;

use App\Entity\Location;
use Webmozart\Assert\Assert;

class LocationFactory
{
    public static function create(array $parameters): Location
    {
        Assert::keyExists($parameters, 'country', 'Country not injected');
        Assert::keyExists($parameters, 'latitude', 'Latitude not injected');
        Assert::keyExists($parameters, 'longitude', 'Longitude not injected');
        Assert::keyExists($parameters, 'locality', 'Locality not injected');

        $location = new Location();
        $location->setCountry($parameters['country'])
            ->setLatitude($parameters['latitude'])
            ->setLongitude($parameters['longitude'])
            ->setLocality($parameters['locality'])
        ;

        return $location;
    }
}
