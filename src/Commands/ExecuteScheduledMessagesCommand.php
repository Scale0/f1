<?php

namespace App\Commands;

use App\Repository\ScheduledMessageRepository;
use App\Service\F1ServiceInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ExecuteScheduledMessagesCommand extends Command
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var string
     */
    protected static $defaultName = 'app:execute-scheduled-messages';

    /**
     * @var MessageBusInterface
     */
    private $bus;
    /**
     * @var ScheduledMessageRepository
     */
    private $scheduledMessageRepository;

    /**
     * ScheduledMessage constructor.
     *
     * @param ScheduledMessageRepository $scheduledMessageRepository
     * @param ManagerRegistry            $managerRegistry
     * @param MessageBusInterface        $bus
     */
    public function __construct(
        ScheduledMessageRepository $scheduledMessageRepository,
        ManagerRegistry $managerRegistry,
        MessageBusInterface $bus
    )
    {
        $this->scheduledMessageRepository = $scheduledMessageRepository;
        $this->managerRegistry = $managerRegistry;
        $this->bus = $bus;

        parent::__construct();
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var  $scheduledMessagesToExecute */
        $scheduledMessagesToExecute = $this->scheduledMessageRepository->findMessagesToExecute();

        foreach ($scheduledMessagesToExecute as $scheduledMessage) {
            $messageClassString = $scheduledMessage->getMessage();
            $this->bus->dispatch(new $messageClassString($scheduledMessage->getParameters()));
            $this->managerRegistry->getManager()->remove($scheduledMessage);
        }
        return 0;
    }

    /**
     * Set configuration description.
     */
    protected function configure()
    {
        $this->setDescription('Executes all scheduled messages');
    }
}
