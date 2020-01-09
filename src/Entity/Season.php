<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 */
class Season
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Race", mappedBy="season")
     */
    private $Race;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    public function __construct()
    {
        $this->Race = new ArrayCollection();
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Race[]
     */
    public function getRace(): Collection
    {
        return $this->Race;
    }

    public function addRace(Race $race): self
    {
        if (!$this->Race->contains($race)) {
            $this->Race[] = $race;
            $race->setSeason($this);
        }

        return $this;
    }

    public function removeRace(Race $race): self
    {
        if ($this->Race->contains($race)) {
            $this->Race->removeElement($race);
            // set the owning side to null (unless already changed)
            if ($race->getSeason() === $this) {
                $race->setSeason(null);
            }
        }

        return $this;
    }

}
