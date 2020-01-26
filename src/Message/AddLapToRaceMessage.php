<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\DriverConstructorSeason;
use App\Entity\Race;

class AddLapToRaceMessage
{
    /** @var Race */
    private $race;
    /** @var DriverConstructorSeason */
    private $driver;
    /** @var string */
    private $time;
    /** @var integer */
    private $position;
    /** @var integer */
    private $lap;

    /**
     * @return Race
     */
    public function getRace(): Race
    {
        return $this->race;
    }

    /**
     * @param Race $race
     *
     * @return self
     */
    public function setRace(Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    /**
     * @return DriverConstructorSeason
     */
    public function getDriver(): DriverConstructorSeason
    {
        return $this->driver;
    }

    /**
     * @param DriverConstructorSeason $driver
     *
     * @return self
     */
    public function setDriver(DriverConstructorSeason $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     *
     * @return self
     */
    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return self
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getLap(): int
    {
        return $this->lap;
    }

    /**
     * @param int $lap
     *
     * @return self
     */
    public function setLap(int $lap): self
    {
        $this->lap = $lap;

        return $this;
    }
}
