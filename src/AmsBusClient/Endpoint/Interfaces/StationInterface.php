<?php

namespace AmsBusClient\Endpoint\Interfaces;

interface StationInterface extends BaseInterface
{
    CONST ENDPOINT_MASK_SEARCH = 'MaskSearch';

    /**
     * Function enumerates the list of objects (destinations and stations) complies with the entered mask.
     * Function returns maximally 30 objects.
     *
     * HTTP: GET
     *
     * @param string $mask
     *
     * @return mixed
     */
    public function search($mask);
} 