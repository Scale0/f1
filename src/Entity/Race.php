<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaceRepository")
 */
class Race
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="Race")
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\Column(type="integer")
     */
    private $round;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Circuit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Circuit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RaceResult", mappedBy="Race")
     */
    private $raceResults;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lap", mappedBy="race")
     */
    private $laps;

    public function __construct()
    {
        $this->raceResults = new ArrayCollection();
        $this->laps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->Location;
    }

    public function setLocation(?Location $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(int $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCircuit(): ?Circuit
    {
        return $this->Circuit;
    }

    public function setCircuit(?Circuit $Circuit): self
    {
        $this->Circuit = $Circuit;

        return $this;
    }

    /**
     * @return Collection|RaceResult[]
     */
    public function getRaceResults(): Collection
    {
        return $this->raceResults;
    }

    public function addRaceResult(RaceResult $raceResult): self
    {
        if (!$this->raceResults->contains($raceResult)) {
            $this->raceResults[] = $raceResult;
            $raceResult->setRace($this);
        }

        return $this;
    }

    public function removeRaceResult(RaceResult $raceResult): self
    {
        if ($this->raceResults->contains($raceResult)) {
            $this->raceResults->removeElement($raceResult);
            // set the owning side to null (unless already changed)
            if ($raceResult->getRace() === $this) {
                $raceResult->setRace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lap[]
     */
    public function getLaps(): Collection
    {
        return $this->laps;
    }

    public function addLap(Lap $lap): self
    {
        if (!$this->laps->contains($lap)) {
            $this->laps[] = $lap;
            $lap->setRace($this);
        }

        return $this;
    }

    public function removeLap(Lap $lap): self
    {
        if ($this->laps->contains($lap)) {
            $this->laps->removeElement($lap);
            // set the owning side to null (unless already changed)
            if ($lap->getRace() === $this) {
                $lap->setRace(null);
            }
        }

        return $this;
    }
}
