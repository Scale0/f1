<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddSeasonMessage;
use App\Service\Season\SeasonFactory;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AddSeasonHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
{
    public function __invoke(AddSeasonMessage $message)
    {
        $season = SeasonFactory::create(['year' => $message->getYear()]);

        $this->managerRegistry->getManager()->persist($season);
        $this->managerRegistry->getManager()->flush();

        $this->f1Service->addRaceScheduleToSeason($season);
        $this->f1Service->updateConstructors($season);

    }
}
