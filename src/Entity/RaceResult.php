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
}
