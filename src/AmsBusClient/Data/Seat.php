<?php

namespace AmsBusClient\Data;

use AmsBusClient\Data\Interfaces\SeatInterface;

class Seat implements SeatInterface
{
    protected $tariffs;

    public function __construct()
    {
        $this->tariffs = [];
    }

    /**
     * Return parameters as array
     *
     * @return mixed
     */
    public function asArray()
    {
        $items = [];
        foreach ($this->tariffs as $tariff) {
            $items[] = $tariff->asArray();
        }

        return [
            'tariffs' => $items
        ];
    }

    /**
     * @return array
     */
    public function getTariffs()
    {
        return $this->tariffs;
    }

    /**
     * @param array $tariffs
     * @return $this
     */
    public function setTariffs($tariffs)
    {
        $this->tariffs = $tariffs;

        return $this;
    }

    /**
     * @param array $tariffs
     * @return $this
     */
    public function addTariff($tariff)
    {
        $this->tariffs[] = $tariff;

        return $this;
    }
}