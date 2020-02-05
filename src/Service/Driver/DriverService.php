<?php

declare(strict_types=1);

namespace App\Service\Driver;

use App\Repository\DriverConstructorSeasonRepository;
use App\Repository\DriverRepository;
use App\Repository\SeasonRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

final class DriverService
{
    /** @var DriverRepository  */
    private $driverRepo;

    /** @var DriverConstructorSeasonRepository  */
    private $driverConstructorSeasonRepo;

    /** @var SeasonRepository  */
    private $seasonRepo;
    public function __construct(ManagerRegistry $manager)
    {
        $this->driverRepo = new DriverRepository($manager);
        $this->driverConstructorSeasonRepo = new DriverConstructorSeasonRepository($manager);
        $this->seasonRepo = new SeasonRepository($manager);
    }

    public function findDriverByFirstAndLastName(string $firstname, string $lastname)
    {
        return $this->driverRepo->findOneBy(['firstName' => $firstname, 'lastName' => $lastname]);
    }

    public function findDriversBySeason(int $season)
    {
        $season = $this->seasonRepo->findOneBy(['year' => $season]);
        return $this->driverConstructorSeasonRepo->findBy(['season' => $season]);
    }
}
