<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddDriverToConstructorAndSeasonMessage;
use App\Service\Season\DriverConstructorSeasonFactory;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddDriverToConstructorAndSeasonHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
{
    public function __invoke(AddDriverToConstructorAndSeasonMessage $addDriverToConstructorAndSeasonMessage)
    {
        $parameters =
            [
                'driver' => $addDriverToConstructorAndSeasonMessage->getDriver(),
                'constructor' => $addDriverToConstructorAndSeasonMessage->getConstructor(),
                'season' => $addDriverToConstructorAndSeasonMessage->getSeason()
            ];
        $addDriverToConstructorAndSeasonMessage->getConstructor();

        $driverConstructorSeason = DriverConstructorSeasonFactory::create($parameters);

        $this->managerRegistry->getManager()->persist($driverConstructorSeason);
        $this->managerRegistry->getManager()->flush();

    }
}
