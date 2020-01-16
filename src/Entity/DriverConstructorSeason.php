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
class DriverConstructorSeason
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Driver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Constructor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Constructor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Season;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDriver(): ?Driver
    {
        return $this->Driver;
    }

    public function setDriver(?Driver $Driver): self
    {
        $this->Driver = $Driver;

        return $this;
    }

    public function getConstructor(): ?Constructor
    {
        return $this->Constructor;
    }

    public function setConstructor(?Constructor $Constructor): self
    {
        $this->Constructor = $Constructor;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->Season;
    }

    public function setSeason(?Season $Season): self
    {
        $this->Season = $Season;

        return $this;
    }
}
