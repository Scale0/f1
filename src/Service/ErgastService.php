<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Circuit;
use App\Entity\Constructor;
use App\Entity\Race;
use App\Entity\Season;
use App\Message\AddConstructorMessage;
use App\Message\AddDriverMessage;
use App\Message\AddLapToRaceMessage;
use App\Message\AddRaceToSeasonMessage;
use App\Message\AddResultToRaceMessage;
use App\Message\AddSeasonMessage;
use App\Repository\CircuitRepository;
use App\Repository\ConstructorRepository;
use App\Repository\DriverConstructorSeasonRepository;
use App\Repository\DriverRepository;
use App\Repository\LapRepository;
use App\Repository\RaceResultRepository;
use App\Repository\SeasonRepository;
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

    /** @var LapRepository  */
    private $lapRepository;

    /** @var DriverConstructorSeasonRepository */
    private $driverConstructorSeasonRepo;

    /**
     * @var MessageBus
     */
    private $bus;

    public function __construct(
        SeasonRepository $seasonRepository,
        CircuitRepository $circuitRepository,
        ConstructorRepository $constructorRepository,
        DriverRepository $driverRepository,
        RaceResultRepository $raceResultRepository,
        DriverConstructorSeasonRepository $driverConstructorSeasonRepo,
        LapRepository $lapRepository,
        MessageBusInterface $bus
    ) {
        $this->seasonRepository = $seasonRepository;
        $this->circuitRepository = $circuitRepository;
        $this->constructorRepository = $constructorRepository;
        $this->driverRepository = $driverRepository;
        $this->raceResultRepository = $raceResultRepository;
        $this->driverConstructorSeasonRepo = $driverConstructorSeasonRepo;
        $this->lapRepository = $lapRepository;
        $this->bus = $bus;
    }

    /**
     * @param string $year
     *
     * @throws \Exception
     */
    function addSeason($year): void
    {
        /** @var Season $existingSeason */
        $existingSeason = $this->seasonRepository->findOneBy(['year' => $year]);
        if (empty($existingSeason)) {
            $result = $this->getResultsFromApi($year.'/seasons', false);
            $addSeason = new AddSeasonMessage();
            $addSeason->setYear($result['SeasonTable']['Seasons'][0]['season']);

            $this->bus->dispatch($addSeason);
        }
    }

    /**
     * @param Season $season
     *
     * @throws \Exception
     */
    public function updateConstructors(Season $season): void
    {
        $constructors = $this->getResultsFromApi($season->getYear().'/constructors');
        $rawConstructors = $constructors['ConstructorTable']['Constructors'];

        foreach ($rawConstructors as $rawConstructor) {
            /** @var Constructor $constructor */
            $constructor = $this->constructorRepository->findOneBy(
                ['constructorId' => $rawConstructor['constructorId']]
            );
            if (empty($constructor)) {
                $constructorMessage = new AddConstructorMessage();
                $constructorMessage
                    ->setSeason($season)
                    ->setConstructorId($rawConstructor['constructorId'])
                    ->setName($rawConstructor['name'])
                    ->setNationality($rawConstructor['nationality'])
                ;

                $this->bus->dispatch($constructorMessage);
            } else {
                $this->updateDrivers($season, $constructor);
            }
        }
    }

    /**
     * @param Season $season
     *
     * @throws \Exception
     */
    public function addRaceScheduleToSeason(Season $season): void
    {
        $schedule = $this->getResultsFromApi($season->getYear());
        $rawRaces = $schedule['RaceTable']['Races'];

        foreach ($rawRaces as $rawRace) {
            /** @var Circuit $circuit */
            $circuit = $this->circuitRepository->findBy(['circuitId' => $rawRace['Circuit']['circuitId']]);
            if (empty($circuit)) {

                $rSM = new AddRaceToSeasonMessage();
                $rSM->setCircuitId($rawRace['Circuit']['circuitId'])
                    ->setCircuitName($rawRace['Circuit']['circuitName'])
                    ->setDate(new \DateTime($rawRace['date'].' '.(isset($rawRace['time']) ? $rawRace['time'] : '')))
                    ->setLocationCountry($rawRace['Circuit']['Location']['country'])
                    ->setLocationLocality($rawRace['Circuit']['Location']['locality'])
                    ->setLocationLat($rawRace['Circuit']['Location']['lat'])
                    ->setLocationLong($rawRace['Circuit']['Location']['long'])
                    ->setName($rawRace['raceName'])
                    ->setRound(intval($rawRace['round']))
                    ->setSeason($season)
                ;
                $this->bus->dispatch($rSM);
            }
        }
    }

    function addLapsToRace(Race $race, int $lapCount = 1) : void{
        $year = $race->getSeason()->getYear();
        $round = $race->getRound();
        $lap = $this->getResultsFromApi($year . '/' . $round . '/laps/'. $lapCount);
        $rawRace = $lap['RaceTable']['Races'];
        if (empty($rawRace)) {
            echo "geen laps meer beschikbaar";
            return;
        }
        $timings = $rawRace[0]['Laps'][0]['Timings'];
        $lap = intval($rawRace[0]['Laps'][0]['number']);

        echo "process lap: " . $lap . " of race: " . $race->getCircuit()->getName() . "\n\r";

        foreach ($timings as $timing) {
            $driver = $this->driverRepository->findOneBy(['driverId' => $timing['driverId']]);
            $driver = $this->driverConstructorSeasonRepo->findOneBy(['driver' => $driver, 'season' => $race->getSeason()]);

            $existingLap = $this->lapRepository->findOneBy(['race' => $race, 'lap' => $lap, 'driver' => $driver]);
            if (empty($existingLap)) {
                $lapMessage = new AddLapToRaceMessage();
                $lapMessage
                    ->setRace($race)
                    ->setPosition(intval($timing['position']))
                    ->setLap($lap)
                    ->setDriver($driver)
                    ->setTime($timing['time'])
                ;
                $this->bus->dispatch($lapMessage);
            }
        }
        $this->addLapsToRace($race, ++$lapCount);
    }
    /**
     * @param Season      $season
     * @param Constructor $constructor
     *
     * @throws \Exception
     */
    public function updateDrivers(Season $season, Constructor $constructor)
    {
        $drivers = $this->getResultsFromApi(
            $season->getYear().'/constructors/'.$constructor->getConstructorId().'/drivers'
        );
        $rawDrivers = $drivers['DriverTable']['Drivers'];
        foreach ($rawDrivers as $rawDriver) {
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
                    ->setNationality($rawDriver['nationality'])
                ;
                $this->bus->dispatch($driverMessage);
            }
        }
    }

    /**
     * @param      $url
     *
     * @param bool $limit
     *
     * @return array
     */
    function getResultsFromApi($url, $limit = false): array
    {
        usleep(100000);
        $baseUri = $_ENV['ERGAST_BASE_URI'];
        $client = HttpClient::createForBaseUri($baseUri);
        $response = $client->request('GET', $url.'.json' . ($limit ? '?limit='.$limit : ''));

        return $response->toArray()['MRData'];
    }

    /**
     * @param Race $race
     */
    public function updateRaceResults(Race $race): void
    {
        $rawRaceResults = $this->getResultsFromApi(
            $race->getSeason()
                ->getYear().'/'.$race->getRound().'/results'
        );
        $rawRaceResults = $rawRaceResults['RaceTable']['Races'][0]['Results'];
        foreach ($rawRaceResults as $rawRaceResult) {
            $driver = $this->driverRepository->findOneBy(['driverId' => $rawRaceResult['Driver']['driverId']]);
            $raceResult = $this->raceResultRepository->findBy([
                    'race' => $race,
                    'driver' => $driver
                ]
            );
            if (empty($raceResult)) {
                $fastestLap = $this->returnIntOrNull($rawRaceResult['FastestLap']['lap'] ?? null);
                $fastestLapRank = $this->returnIntOrNull($rawRaceResult['FastestLap']['rank'] ?? null);
                $fastestLapTime = $rawRaceResult['FastestLap']['Time']['time'] ?? null;
                $avgSpeed = $rawRaceResult['FastestLap']['AverageSpeed']['speed'] ?? null;
                $driver = $this->driverConstructorSeasonRepo->findOneBy(['driver' => $driver, 'season' => $race->getSeason()]);
                $raceResultMessage = new AddResultToRaceMessage();
                $raceResultMessage
                    ->setRace($race)
                    ->setDriver($driver)
                    ->setPosition(intval($rawRaceResult['position']))
                    ->setGrid(intval($rawRaceResult['grid']))
                    ->setLaps(intval($rawRaceResult['laps']))
                    ->setStatus($rawRaceResult['status'])
                    ->setFastestLap($fastestLap)
                    ->setFastestLapRank($fastestLapRank)
                    ->setFastestLapTime($fastestLapTime)
                    ->setAvgSpeed($avgSpeed)
                ;
                $this->bus->dispatch($raceResultMessage);
            }
        }
        $this->addLapsToRace($race);
    }

    private function returnIntOrNull($value) {
        return !is_null($value) ? intval($value) : $value;
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
