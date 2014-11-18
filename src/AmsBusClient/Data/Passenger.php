<?php

namespace AmsBusClient\Data;

use AmsBusClient\Data\Interfaces\PassengerInterface;

class Passenger implements PassengerInterface
{
    protected $ticketIdx;
    protected $name;

    /**
     * Return parameters as array
     *
     * @return mixed
     */
    public function asArray()
    {
        return [
            'ticketIdx' => $this->getTicketIdx(),
            'name'      => $this->getName()
        ];
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
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTicketIdx()
    {
        return $this->ticketIdx;
    }

    /**
     * @param mixed $ticketIdx
     */
    public function setTicketIdx($ticketIdx)
    {
        $this->ticketIdx = $ticketIdx;
    }
}
