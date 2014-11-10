<?php

namespace AmsBusClient\Endpoint;

use Guzzle\Http\Message\RequestInterface;
use AmsBusClient\Data\Interfaces\ConnectionInterface as ConnectionDataInterface;
use AmsBusClient\Endpoint\Interfaces\ConnectionInterface;

class Connection extends AbstractEndpoint implements ConnectionInterface
{
    /**
     * Function solves the entered masks of objects and if successful, searches connection. As connections here, are
     * considered only direct connections; connections with stopovers can’t be searched. Function returns maximally 10
     * connections. Basic details (connection handle, connection index, from, to, dates and times, standard price,
     * line number and operator, number of free seats) are returned to each connection. By using parameter
     * {searchFlags} can be requirements on the connection (i.e. search only connections, that don’t require printed
     * e-ticket); entering these requirements is usually pointless because they follow from operator’s characteristics.
     *
     * HTTP: GET|POST
     *
     * @param ConnectionDataInterface $connection
     *
     * @return mixed
     */
    public function search(ConnectionDataInterface $connection)
    {
        $method    = RequestInterface::GET;
        $endpoint  = ConnectionInterface::ENDPOINT_CONNECTION;
        $urlParams = [];
        $data      = $connection->asArray();

        return $this->doRequest($method, $endpoint, $urlParams, $data);
    }

    /**
     * Function searches return connections – means those connections that are suitable for connection there (TO).
     * Entered leaving time {dateTime}  can’t be earlier than time of connection there (TO destination).
     *
     * HTTP: GET|POST
     *
     * @param ConnectionDataInterface $connection
     *
     * @return mixed
     */
    public function searchReturn(ConnectionDataInterface $connection)
    {
        // TODO: Implement searchReturn() method.
    }

    /**
     * Function returns detail information about one concrete connection, means list of tariffs, prices and operators
     * on that connection including seat map of bus, else information that reservation is not working with particular
     * seats.
     *
     * HTTP: GET
     *
     * @param array $urlParams
     *
     * @return mixed
     */
    public function getInfo($urlParams)
    {
        $method    = RequestInterface::GET;
        $endpoint  = ConnectionInterface::ENDPOINT_CONNECTION_INFO;
        $urlParams = $urlParams;
        $data      = [];

        return $this->doRequest($method, $endpoint, $urlParams, $data);
    }
}