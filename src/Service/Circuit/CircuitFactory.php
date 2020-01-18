<?php

declare(strict_types=1);

namespace App\Service\Circuit;

use App\Entity\Circuit;
use App\Entity\Location;
use Webmozart\Assert\Assert;

class CircuitFactory
{
    static public function create($parameters): Circuit
    {
        Assert::keyExists($parameters, 'name', '%s not injected');
        Assert::keyExists($parameters, 'circuitId', '%s not injected');
        Assert::keyExists($parameters, 'location', '%s not injected');
        Assert::string($parameters['name']);
        Assert::string($parameters['circuitId']);
        Assert::isInstanceOf($parameters['location'], Location::class);
        $circuit = new Circuit();
        $circuit->setName($parameters['name'])
            ->setCircuitId($parameters['circuitId'])
            ->setLocation($parameters['location'])
        ;

        return $circuit;
    }
}
