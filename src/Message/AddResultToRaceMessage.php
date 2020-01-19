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
    /** @var integer */
    private $fastestLap;
    /** @var integer */
    private $fastestLapRank;
    /** @var string */
    private $fastestLapTime;
    /** @var string */
    private $avgSpeed;

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
     * @param int|null $laps
     *
     * @return self
     */
    public function setLaps(?int $laps): self
    {
        $this->laps = $laps;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFastestLap(): ?int
    {
        return $this->fastestLap;
    }

    /**
     * @param int|null $fastestLap
     *
     * @return self
     */
    public function setFastestLap(?int $fastestLap): self
    {
        $this->fastestLap = $fastestLap;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFastestLapRank(): ?int
    {
        return $this->fastestLapRank;
    }

    /**
     * @param int|null $fastestLapRank
     *
     * @return self
     */
    public function setFastestLapRank(?int $fastestLapRank): self
    {
        $this->fastestLapRank = $fastestLapRank;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFastestLapTime(): ?string
    {
        return $this->fastestLapTime;
    }

    /**
     * @param string|null $fastestLapTime
     *
     * @return self
     */
    public function setFastestLapTime(?string $fastestLapTime): self
    {
        $this->fastestLapTime = $fastestLapTime;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvgSpeed(): ?string
    {
        return $this->avgSpeed;
    }

    /**
     * @param string|null $avgSpeed
     *
     * @return self
     */
    public function setAvgSpeed(?string $avgSpeed): self
    {
        $this->avgSpeed = $avgSpeed;

        return $this;
    }

}
