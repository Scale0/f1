<?php

declare(strict_types=1);

namespace App\Service\Location;

use App\Entity\Location;
use App\Service\FactoryInterface;
use Webmozart\Assert\Assert;

class LocationFactory implements FactoryInterface
{
    public static function create(array $parameters): Location
    {
        Assert::keyExists($parameters, 'country', '%s not injected');
        Assert::keyExists($parameters, 'latitude', '%s not injected');
        Assert::keyExists($parameters, 'longitude', '%s not injected');
        Assert::keyExists($parameters, 'locality', '%s not injected');
        Assert::string($parameters['country']);
        Assert::string($parameters['latitude']);
        Assert::string($parameters['longitude']);
        Assert::string($parameters['locality']);

        $location = new Location();
        $location->setCountry($parameters['country'])
            ->setLatitude($parameters['latitude'])
            ->setLongitude($parameters['longitude'])
            ->setLocality($parameters['locality'])
        ;

        return $location;
    }
}
