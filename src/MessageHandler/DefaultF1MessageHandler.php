<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\F1ApiServiceInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\MessageBusInterface;

class DefaultF1MessageHandler
{
    /** @var ManagerRegistry */
    protected $managerRegistry;

    /** @var F1ApiServiceInterface */
    protected $f1Service;

    /** @var MessageBusInterface */
    protected $bus;

    public function __construct(ManagerRegistry $managerRegistry, F1ApiServiceInterface $f1Service, MessageBusInterface $bus)
    {
        $this->managerRegistry = $managerRegistry;
        $this->f1Service = $f1Service;
        $this->bus = $bus;
    }
}
