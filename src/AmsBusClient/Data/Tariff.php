<?php

namespace AmsBusClient\Data;

use AmsBusClient\Data\Interfaces\TariffInterface;

class Tariff implements TariffInterface
{
    protected $tarCode;
    protected $numPlaces;

    /**
     * Return parameters as array
     *
     * @return mixed
     */
    public function asArray()
    {
        return [
            'tarCode'   => $this->getTarCode(),
            'numPlaces' => intval($this->getNumPlaces())
        ];
    }

    /**
     * @return mixed
     */
    public function getNumPlaces()
    {
        return $this->numPlaces;
    }

    /**
     * @param mixed $numPlaces
     */
    public function setNumPlaces($numPlaces)
    {
        $this->numPlaces = $numPlaces;
    }

    /**
     * @return mixed
     */
    public function getTarCode()
    {
        return $this->tarCode;
    }

    /**
     * @param mixed $tarCode
     */
    public function setTarCode($tarCode)
    {
        $this->tarCode = $tarCode;
    }


}