<?php

namespace AmsBusClient\Endpoint;

use AmsBusClient\Endpoint\Interfaces\BaseInterface;
use AmsBusClient\Endpoint\Interfaces\StationInterface;

class Station extends AbstractEndpoint implements StationInterface
{
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
    public function search($mask)
    {
        $method           = BaseInterface::GET;
        $endpoint         = StationInterface::ENDPOINT_MASK_SEARCH;
        $urlParams        = [];
        $options['query'] = ['mask' => $mask];

        return $this->doRequest($method, $endpoint, $urlParams, $options);

    }
}
