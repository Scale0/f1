<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddDriverMessage;
use App\Message\AddDriverToConstructorAndSeasonMessage;
use App\Service\Driver\DriverFactory;
use App\Service\F1ServiceInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AddDriverHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
{
    public function __invoke(AddDriverMessage $addDriverMessage)
    {
        $parameters = [
            'driverId' => $addDriverMessage->getDriverId(),
            'code' => $addDriverMessage->getCode(),
            'permanentNumber' => $addDriverMessage->getPermanentNumber(),
            'firstName' => $addDriverMessage->getFirstName(),
            'lastName' => $addDriverMessage->getLastName(),
            'dateOfBirth' => $addDriverMessage->getDateOfBirth(),
            'nationality' => $addDriverMessage->getNationality()
        ];
        $driver = DriverFactory::create($parameters);

        $this->managerRegistry->getManager()
            ->persist($driver)
        ;
        $this->managerRegistry->getManager()
            ->flush()
        ;

        $driverToConstructorAndSeason = new AddDriverToConstructorAndSeasonMessage();
        $driverToConstructorAndSeason
            ->setDriver($driver)
            ->setConstructor($addDriverMessage->getConstructor())
            ->setSeason($addDriverMessage->getSeason())
        ;

        $this->bus->dispatch($driverToConstructorAndSeason);

        dump($driver);
        die();
        // TODO: Implement __invoke() method.
    }
}
