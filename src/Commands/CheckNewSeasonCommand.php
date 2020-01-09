<?php

declare(strict_types=1);

namespace App\Commands;

use App\Entity\Season;
use App\Repository\SeasonRepository;
use App\Service\F1ServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckNewSeasonCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:f1:season:update';

    /**
     * @var F1ServiceInterface
     */
    private $f1Service;

    /**
     * @var SeasonRepository
     */
    private $seasonRepository;

    /**
     * ScheduledMessage constructor.
     *
     * @param F1ServiceInterface $f1Service
     * @param SeasonRepository $seasonRepository
     */
    public function __construct(
        F1ServiceInterface $f1Service,
        SeasonRepository $seasonRepository
    )
    {
        $this->f1Service = $f1Service;
        $this->seasonRepository = $seasonRepository;

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
        $output->writeln('checking new season
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
        /** @var Season $currentSeason */
        $currentSeason = $this->seasonRepository->findCurrentSeason();

        if (empty($currentSeason) || !empty($currentSeason) && $currentSeason[0]->getYear() < date('Y')) {
            $this->f1Service->addSeason(date('Y'));
        }
        return 0;
    }
    /**
     * Set configuration description.
     */
    protected function configure()
    {
        $this->setDescription('updates current season to current year');
    }
}
