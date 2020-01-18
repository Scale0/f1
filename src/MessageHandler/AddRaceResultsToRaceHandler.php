<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddRaceResultsToRaceMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddRaceResultsToRaceHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
{
    public function __invoke(AddRaceResultsToRaceMessage $artr)
    {
        $this->f1Service->updateRaceResults($artr->getRace());
    }
}
