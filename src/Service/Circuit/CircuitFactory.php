<?php

declare(strict_types=1);

namespace App\Service\Circuit;

use App\Entity\Circuit;
use Webmozart\Assert\Assert;

class CircuitFactory
{
    static public function create($parameters): Circuit
    {
        Assert::keyExists($parameters, 'name', 'name not injected');
        Assert::keyExists($parameters, 'circuitId', 'circuitId not injected');
        Assert::keyExists($parameters, 'location', 'location not injected');
        $circuit = new Circuit();
        $circuit->setName($parameters['name'])
            ->setCircuitId($parameters['circuitId'])
            ->setLocation($parameters['location'])
        ;

        return $circuit;
    }
}
