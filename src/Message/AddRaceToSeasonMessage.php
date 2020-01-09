<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Season;

class AddRaceToSeasonMessage
{
    /** @var Season */
    private $season;

    /** @var int */
    private $round;

    /** @var string */
    private $name;

    /** @var \DateTime */
    private $date;

    /** @var string */
    private $circuitId;

    /** @var string */
    private $circuitName;

    /** @var string */
    private $locationLat;

    /** @var string */
    private $locationLong;

    /** @var string */
    private $locationLocality;

    /** @var string */
    private $locationCountry;

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
     * @return $this
     */
    public function setSeason(Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    /**
     * @return int
     */
    public function getRound(): int
    {
        return $this->round;
    }

    /**
     * @param int $round
     *
     * @return $this
     */
    public function setRound(int $round): self
    {
        $this->round = $round;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getCircuitId(): string
    {
        return $this->circuitId;
    }

    /**
     * @param string $circuitId
     *
     * @return $this
     */
    public function setCircuitId(string $circuitId): self
    {
        $this->circuitId = $circuitId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCircuitName(): string
    {
        return $this->circuitName;
    }

    /**
     * @param string $circuitName
     *
     * @return $this
     */
    public function setCircuitName(string $circuitName): self
    {
        $this->circuitName = $circuitName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocationLat(): string
    {
        return $this->locationLat;
    }

    /**
     * @param string $locationLat
     *
     * @return $this
     */
    public function setLocationLat(string $locationLat): self
    {
        $this->locationLat = $locationLat;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocationLong(): string
    {
        return $this->locationLong;
    }

    /**
     * @param string $locationLong
     *
     * @return $this
     */
    public function setLocationLong(string $locationLong): self
    {
        $this->locationLong = $locationLong;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocationLocality(): string
    {
        return $this->locationLocality;
    }

    /**
     * @param string $locationLocality
     *
     * @return $this
     */
    public function setLocationLocality(string $locationLocality): self
    {
        $this->locationLocality = $locationLocality;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocationCountry(): string
    {
        return $this->locationCountry;
    }

    /**
     * @param string $locationCountry
     *
     * @return $this
     */
    public function setLocationCountry(string $locationCountry): self
    {
        $this->locationCountry = $locationCountry;

        return $this;
    }


}
