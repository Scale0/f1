<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddSeasonMessage;
use App\Service\F1ServiceInterface;
use App\Service\Season\SeasonFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AddSeasonHandler implements MessageHandlerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var F1ServiceInterface
     */
    private $f1Service;

    public function __construct(ManagerRegistry $managerRegistry, F1ServiceInterface $f1Service)
    {
        $this->managerRegistry = $managerRegistry;
        $this->f1Service = $f1Service;
    }

    public function __invoke(AddSeasonMessage $message)
    {
        $season = SeasonFactory::create(['year' => $message->getYear()]);

        $this->managerRegistry->getManager()->persist($season);
        $this->managerRegistry->getManager()->flush();

        $this->f1Service->addRaceScheduleToSeason($season);
        $this->f1Service->updateConstructors($season);

    }
}
