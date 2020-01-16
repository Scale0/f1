<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddDriverToConstructorAndSeasonMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddDriverToConstructorAndSeasonHandler implements MessageHandlerInterface
{
    public function __invoke(AddDriverToConstructorAndSeasonMessage $addDriverToConstructorAndSeasonMessage)
    {
        dump($addDriverToConstructorAndSeasonMessage);die();
        // TODO: Implement __invoke() method.
    }
}
