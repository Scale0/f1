<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\DriverConstructorSeason;
use App\Entity\Race;

class AddResultToRaceMessage
{
    /** @var Race */
    private $race;
    /** @var DriverConstructorSeason */
    private $driver;
    /** @var integer */
    private $position;
    /** @var string */
    private $status;
    /** @var integer */
    private $grid;
    /** @var integer */
    private $laps;

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
    public function setRace($race): self
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
    public function setPosition($position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param int $grid
     *
     * @return self
     */
    public function setGrid($grid): self
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * @return int
     */
    public function getLaps(): int
    {
        return $this->laps;
    }

    /**
     * @param int $laps
     *
     * @return self
     */
    public function setLaps(int $laps): self
    {
        $this->laps = $laps;

        return $this;
    }

}
