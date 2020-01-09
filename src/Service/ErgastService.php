<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Circuit;
use App\Entity\Season;
use App\Entity\ScheduledMessage;
use App\Message\AddRaceToSeasonMessage;
use App\Message\AddSeasonMessage;
use App\Repository\CircuitRepository;
use App\Repository\ScheduledMessageRepository;
use App\Repository\SeasonRepository;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class ErgastService implements F1ServiceInterface
{
    /**
     * @var SeasonRepository;
     */
    private $seasonRepository;

    /**
     * @var CircuitRepository;
     */
    private $circuitRepository;

    /**
     * @var ScheduledMessageRepository
     */
    private $scheduledMessageRepository;

    /**
     * @var MessageBus
     */
    private $bus;

    public function __construct(
        ScheduledMessageRepository $scheduledMessageRepository,
        SeasonRepository $seasonRepository,
        CircuitRepository $circuitRepository,
        MessageBusInterface $bus)
    {
        $this->scheduledMessageRepository = $scheduledMessageRepository;
        $this->seasonRepository = $seasonRepository;
        $this->circuitRepository = $circuitRepository;
        $this->bus = $bus;
    }

    function addSeason($year): void
    {
        /** @var Season $existingSeason */
        $existingSeason = $this->seasonRepository->findOneBy(['year' => $year]);
        if (empty($existingSeason)) {
            $result = $this->getResultsFromApi($year .'/seasons', false);
            $addSeason = new AddSeasonMessage();
            $addSeason->setYear($result['SeasonTable']['Seasons'][0]['season']);

            $this->bus->dispatch($addSeason);
        }
    }

    public function addRaceScheduleToSeason(Season $season): void
    {
        $schedule = $this->getResultsFromApi($season->getYear());
        $rawRaces = $schedule['RaceTable']['Races'];

        foreach($rawRaces as $rawRace) {
            /** @var Circuit $circuit */
            $circuit = $this->circuitRepository->findBy(['CircuitId' => $rawRace['Circuit']['circuitId']]);
            if (empty($circuit)) {
                $rSM = new AddRaceToSeasonMessage();
                $rSM->setCircuitId($rawRace['Circuit']['circuitId'])
                    ->setCircuitName($rawRace['Circuit']['circuitName'])
                    ->setDate(new \DateTime($rawRace['date']. ' ' . $rawRace['time']))
                    ->setLocationCountry($rawRace['Circuit']['Location']['country'])
                    ->setLocationLocality($rawRace['Circuit']['Location']['locality'])
                    ->setLocationLat($rawRace['Circuit']['Location']['lat'])
                    ->setLocationLong($rawRace['Circuit']['Location']['long'])
                    ->setName($rawRace['raceName'])
                    ->setRound(intval($rawRace['round']))
                    ->setSeason($season);

                $this->bus->dispatch($rSM);
            }
        }
    }

    function getResultsFromApi($url): array
    {
        $baseUri = $_ENV['ERGAST_BASE_URI'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        CURL_SETOPT($ch, CURLOPT_URL, $baseUri . $url . '.json');
        $result = curl_exec($ch);
        return json_decode($result, true)['MRData'];
    }
}
