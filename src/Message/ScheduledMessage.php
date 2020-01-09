<?php
/**
 * Created by PhpStorm.
 * User: jos
 * Date: 7-2-19
 * Time: 20:45.
 */

namespace App\Message;

class ScheduledMessage implements ScheduledMessageInterface
{
    /**
     * @var array
     */
    private $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
