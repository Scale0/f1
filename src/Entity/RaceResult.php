<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaceResultRepository")
 */
class RaceResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Race", inversedBy="raceResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DriverConstructorSeason", inversedBy="raceResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $grid;

    /**
     * @ORM\Column(type="integer")
     */
    private $laps;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fastestLap;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fastestLapRank;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $fastestLapTime;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $avgSpeed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getDriver(): ?DriverConstructorSeason
    {
        return $this->driver;
    }

    public function setDriver(?DriverConstructorSeason $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getGrid(): ?int
    {
        return $this->grid;
    }

    public function setGrid(int $grid): self
    {
        $this->grid = $grid;

        return $this;
    }

    public function getLaps(): ?int
    {
        return $this->laps;
    }

    public function setLaps(int $laps): self
    {
        $this->laps = $laps;

        return $this;
    }

    public function getFastestLap(): ?int
    {
        return $this->fastestLap;
    }

    public function setFastestLap(?int $fastestLap): self
    {
        $this->fastestLap = $fastestLap;

        return $this;
    }

    public function getFastestLapRank(): ?int
    {
        return $this->fastestLapRank;
    }

    public function setFastestLapRank(?int $fastestLapRank): self
    {
        $this->fastestLapRank = $fastestLapRank;

        return $this;
    }

    public function getFastestLapTime(): ?string
    {
        return $this->fastestLapTime;
    }

    public function setFastestLapTime(?string $fastestLapTime): self
    {
        $this->fastestLapTime = $fastestLapTime;

        return $this;
    }

    public function getAvgSpeed(): ?string
    {
        return $this->avgSpeed;
    }

    public function setAvgSpeed(?string $avgSpeed): self
    {
        $this->avgSpeed = $avgSpeed;

        return $this;
    }
}
