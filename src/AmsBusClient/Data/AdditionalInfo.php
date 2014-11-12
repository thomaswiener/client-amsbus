<?php

namespace AmsBusClient\Data;

use AmsBusClient\Data\Interfaces\AdditionalInfoInterface;

class AdditionalInfo implements AdditionalInfoInterface
{
    protected $passengers;

    /**
     * Return parameters as array
     *
     * @return mixed
     */
    public function asArray()
    {
        $items = [];

        foreach ($this->getPassengers() as $passenger) {
            $items[] = $passenger->asArray();
        }

        return $items;
    }

    /**
     * @return mixed
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * @param mixed $passengers
     * @return $this
     */
    public function setPassengers($passengers)
    {
        $this->passengers = $passengers;

        return $this;
    }

    /**
     * @param mixed $passengers
     * @return $this
     */
    public function addPassenger($passenger)
    {
        $this->passengers[] = $passenger;

        return $this;
    }


}