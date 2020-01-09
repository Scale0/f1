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
     * @var F1ServiceInterface
     */
    private $f1Service;
    /**
     * ScheduledMessage constructor.
     *
     * @param ScheduledMessageRepository $scheduledMessageRepository
     * @param ManagerRegistry            $managerRegistry
     * @param MessageBusInterface        $bus
     * @param F1ServiceInterface         $f1Service
     */
    public function __construct(
        ScheduledMessageRepository $scheduledMessageRepository,
        ManagerRegistry $managerRegistry,
        MessageBusInterface $bus,
        F1ServiceInterface $f1Service
    )
    {
        $this->scheduledMessageRepository = $scheduledMessageRepository;
        $this->managerRegistry = $managerRegistry;
        $this->bus = $bus;
        $this->f1Service = $f1Service;

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
        $scheduledMessagesToExecute = $this->scheduledMessageRepository->findMessagesToExecute();

        foreach ($scheduledMessagesToExecute as $scheduledMessage) {
            $messageClassString = $scheduledMessage->getMessage();
            $this->bus->dispatch(new $messageClassString($scheduledMessage->getParameters()));
            $this->managerRegistry->getManager()->remove($scheduledMessage);
        }

        $this->managerRegistry->getManager()->flush();
        $output->writeln('Processing Messages
                                     d88b
                     _______________|8888|_______________
                    |_____________ ,~~~~~~. _____________|
  _________         |_____________: mmmmmm :_____________|         _________
 / _______ \   ,----|~~~~~~~~~~~,\'\ _...._ /`.~~~~~~~~~~~|----,   / _______ \
| /       \ |  |    |       |____|,d~    ~b.|____|       |    |  | /       \ |
||         |-------------------\-d.-~~~~~~-.b-/-------------------|         ||
||         | |8888 ....... _,===~/......... \~===._         8888| |         ||
||         |=========_,===~~======._.=~~=._.======~~===._=========|         ||
||         | |888===~~ ...... //,, .`~~~~\'. .,\\        ~~===888|  |         ||
||        |===================,P\'.::::::::.. `?,===================|        ||
||        |_________________,P\'_::----------.._`?,_________________|        ||
`|        |-------------------~~~~~~~~~~~~~~~~~~-------------------|        |\'
  \_______/                                                        \_______/
</>');
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
