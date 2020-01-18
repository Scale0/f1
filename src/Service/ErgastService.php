<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Circuit;
use App\Entity\Constructor;
use App\Entity\Driver;
use App\Entity\Race;
use App\Entity\Season;
use App\Entity\ScheduledMessage;
use App\Message\AddConstructorMessage;
use App\Message\AddDriverMessage;
use App\Message\AddRaceToSeasonMessage;
use App\Message\AddResultToRaceMessage;
use App\Message\AddSeasonMessage;
use App\Repository\CircuitRepository;
use App\Repository\ConstructorRepository;
use App\Repository\DriverRepository;
use App\Repository\RaceResultRepository;
use App\Repository\ScheduledMessageRepository;
use App\Repository\SeasonRepository;
use Symfony\Component\Asset\Package;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class ErgastService implements F1ServiceInterface
{
    /** @var SeasonRepository */
    private $seasonRepository;
    /** @var CircuitRepository */
    private $circuitRepository;
    /** @var ConstructorRepository */
    private $constructorRepository;
    /** @var DriverRepository */
    private $driverRepository;
    /** @var RaceResultRepository */
    private $raceResultRepository;
    /** @var ScheduledMessageRepository */
    private $scheduledMessageRepository;
    /**
     * @var MessageBus
     */
    private $bus;

    public function __construct(
        ScheduledMessageRepository $scheduledMessageRepository,
        SeasonRepository $seasonRepository,
        CircuitRepository $circuitRepository,
        ConstructorRepository $constructorRepository,
        DriverRepository $driverRepository,
        RaceResultRepository $raceResultRepository,
        MessageBusInterface $bus
    )
    {
        $this->scheduledMessageRepository = $scheduledMessageRepository;
        $this->seasonRepository = $seasonRepository;
        $this->circuitRepository = $circuitRepository;
        $this->constructorRepository = $constructorRepository;
        $this->driverRepository = $driverRepository;
        $this->raceResultRepository = $raceResultRepository;
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

    public function updateConstructors(Season $season): void
    {
        $constructors = $this->getResultsFromApi($season->getYear() . '/constructors');
        $rawConstructors = $constructors['ConstructorTable']['Constructors'];

        foreach ($rawConstructors as $rawConstructor) {
            /** @var Constructor $constructor */
            $constructor = $this->constructorRepository->findOneBy(['constructorId' => $rawConstructor['constructorId']]);
            if (empty($constructor)) {
                $constructorMessage = new AddConstructorMessage();
                $constructorMessage
                    ->setSeason($season)
                    ->setConstructorId($rawConstructor['constructorId'])
                    ->setName($rawConstructor['name'])
                    ->setNationality($rawConstructor['nationality']);

                $this->bus->dispatch($constructorMessage);
            } else {
                $this->updateDrivers($season, $constructor);
            }
        }
    }

    public function addRaceScheduleToSeason(Season $season): void
    {
        $schedule = $this->getResultsFromApi($season->getYear());
        $rawRaces = $schedule['RaceTable']['Races'];


        foreach($rawRaces as $rawRace) {
            /** @var Circuit $circuit */
            $circuit = $this->circuitRepository->findBy(['circuitId' => $rawRace['Circuit']['circuitId']]);
            if (empty($circuit)) {

                $rSM = new AddRaceToSeasonMessage();
                $rSM->setCircuitId($rawRace['Circuit']['circuitId'])
                    ->setCircuitName($rawRace['Circuit']['circuitName'])
                    ->setDate(new \DateTime($rawRace['date']. ' ' . (isset($rawRace['time']) ? $rawRace['time'] : '')))
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

    /**
     * @param Season      $season
     * @param Constructor $constructor
     *
     * @throws \Exception
     */
    public function updateDrivers(Season $season, Constructor $constructor)
    {
        $drivers = $this->getResultsFromApi($season->getYear() . '/constructors/' . $constructor->getConstructorId() . '/drivers');
        $rawDrivers = $drivers['DriverTable']['Drivers'];
        foreach($rawDrivers as $rawDriver) {
            $driver = $this->driverRepository->findBy(['driverId' => $rawDriver['driverId']]);
            if (empty($driver)) {
                $driverMessage = new AddDriverMessage();
                $driverMessage
                    ->setConstructor($constructor)
                    ->setSeason($season)
                    ->setDriverId($rawDriver['driverId'])
                    ->setPermanentNumber(intval($rawDriver['permanentNumber']))
                    ->setCode($rawDriver['code'])
                    ->setFirstName($rawDriver['givenName'])
                    ->setLastName($rawDriver['familyName'])
                    ->setDateOfBirth(new \DateTime($rawDriver['dateOfBirth']))
                    ->setNationality($rawDriver['nationality']);
                $this->bus->dispatch($driverMessage);
            }
        }
    }

    function getResultsFromApi($url): array
    {
        $baseUri = $_ENV['ERGAST_BASE_URI'];
        $client = HttpClient::createForBaseUri($baseUri);
        $response = $client->request('GET', $url.'.json');

        return $response->toArray()['MRData'];
    }

    public function updateRaceResults(Race $race): void
    {
        $rawRaceResults = $this->getResultsFromApi($race->getSeason()->getYear() . '/' . $race->getRound() . '/results');
        $rawRaceResults = $rawRaceResults['RaceTable']['Races'][0]['Results'];
        foreach($rawRaceResults as $rawRaceResult) {
            $driver = $this->driverRepository->findBy(['driverId' => $rawRaceResult['Driver']['driverId']]);
            $raceResult = $this->raceResultRepository->findBy([
                'race' => $race,
                'driver' => $driver
            ]);
            if (empty($raceResult)) {
                $raceResultMessage = new AddResultToRaceMessage();
                $raceResultMessage
                    ->setRace($race)
                    ->setDriver($driver)
                    ->setPosition(intval($rawRaceResult['position']))
                    ->setGrid(intval($rawRaceResult['grid']))
                    ->setLaps(intval($rawRaceResult['laps']))
                    ->setStatus($rawRaceResult['status'])
                ;
            }

        }
        die();
    }

    function asciiF1Car(): string
    {
        return '
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
</>';
    }
}
