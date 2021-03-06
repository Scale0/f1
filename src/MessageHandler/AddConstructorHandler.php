<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddConstructorMessage;
use App\Service\Constructor\ConstructorFactory;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddConstructorHandler extends DefaultF1MessageHandler implements MessageHandlerInterface
{
    public function __invoke(AddConstructorMessage $addConstructorMessage)
    {
        $parameters = [
            'constructorId' => $addConstructorMessage->getConstructorId(),
            'name' => $addConstructorMessage->getName(),
            'nationality' => $addConstructorMessage->getNationality()];
        $constructor = ConstructorFactory::create($parameters);

        $this->managerRegistry->getManager()->persist($constructor);
        $this->managerRegistry->getManager()->flush();

        $this->f1Service->updateDrivers($addConstructorMessage->getSeason(), $constructor);
    }
}
