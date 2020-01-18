<?php

declare(strict_types=1);

namespace App\Commands;

use App\Entity\Season;
use App\Repository\SeasonRepository;
use App\Service\F1ServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getArgument('year') ?? date('Y');
        $output->writeln('checking for season ' . $year . ' '. $this->f1Service->asciiF1Car());
        /** @var Season $currentSeason */
        $currentSeason = $this->seasonRepository->findSeasonByYear($year);

        if (empty($currentSeason)) {
            $this->f1Service->addSeason($year);
        }

        $output->writeln('Done!');
        return 0;
    }
    /**
     * Set configuration description.
     */
    protected function configure()
    {
        $this
            ->setDescription('updates current season to current year')
            ->addArgument('year', InputArgument::OPTIONAL, 'Year to get data from');
    }
}
