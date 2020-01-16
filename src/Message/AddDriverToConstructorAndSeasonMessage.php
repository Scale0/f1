<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Constructor;
use App\Entity\Driver;
use App\Entity\Season;

class AddDriverToConstructorAndSeasonMessage
{
    /** @var Driver */
    private $driver;
    /** @var Constructor */
    private $constructor;
    /** @var Season */
    private $season;

    /**
     * @return Driver
     */
    public function getDriver(): Driver
    {
        return $this->driver;
    }

    /**
     * @param Driver $driver
     *
     * @return self
     */
    public function setDriver(Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return Constructor
     */
    public function getConstructor(): Constructor
    {
        return $this->constructor;
    }

    /**
     * @param Constructor $constructor
     *
     * @return self
     */
    public function setConstructor(Constructor $constructor): self
    {
        $this->constructor = $constructor;

        return $this;
    }

    /**
     * @return Season
     */
    public function getSeason(): Season
    {
        return $this->season;
    }

    /**
     * @param Season $season
     *
     * @return self
     */
    public function setSeason(Season $season): self
    {
        $this->season = $season;

        return $this;
    }
}
