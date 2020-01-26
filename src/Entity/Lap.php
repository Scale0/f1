<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DriverConstructorSeasonRepository")
 * @ORM\Table(
 *     uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="uniqueKey",
 *          columns={"driver_id", "constructor_id", "season_id"}
 *      )
 *     }
 * )
 */
/**
 * @ORM\Entity(repositoryClass="App\Repository\LapRepository")
 * @ORM\Table(
 *     uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *       name="RaceDriverLapKey",
 *       columns={"race_id", "driver_id", "lap"}
 *      )
 *     }
 * )
 */
class Lap
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DriverConstructorSeason")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Race", inversedBy="laps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     */
    private $lap;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

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

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getLap(): ?int
    {
        return $this->lap;
    }

    public function setLap(int $lap): self
    {
        $this->lap = $lap;

        return $this;
    }
}
