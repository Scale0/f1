<?php

declare(strict_types=1);

namespace App\Message;

final class AddConstructorMessage
{
    private $constructorId;

    private $name;

    private $nationality;

    /**
     * @return mixed
     */
    public function getConstructorId()
    {
        return $this->constructorId;
    }

    /**
     * @param mixed $constructorId
     *
     * @return self
     */
    public function setConstructorId($constructorId): self
    {
        $this->constructorId = $constructorId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $nationality
     *
     * @return self
     */
    public function setNationality($nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }


}
