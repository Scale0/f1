<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Race;
use Webmozart\Assert\Assert;

class AddRaceResultsToRaceMessage extends ScheduledMessage
{
    /** @var Race  */
    private $race;

    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
        Assert::keyExists($parameters, 'race');
        Assert::isInstanceOf($parameters['race'], Race::class);
        $this->race = $parameters['race'];
    }

    /**
     * @return Race
     */
    public function getRace()
    {
        return $this->race;
    }
}
