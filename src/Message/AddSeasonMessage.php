<?php

declare(strict_types=1);

namespace App\Message;


final class AddSeasonMessage
{

    /** @var integer */
    private $year;

    /**
     * @param mixed $year
     *
     * @return $this
     */
    public function setYear($year): self
    {
        $this->year = intval($year);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }
}
