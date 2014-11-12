<?php

namespace AmsBusClient\Endpoint;

use AmsBusClient\Endpoint\Interfaces\BaseInterface;
use AmsBusClient\Endpoint\Interfaces\SeatInterface;
use AmsBusClient\Data\Interfaces\SeatInterface as SeatDataInterface;

class Seat extends AbstractEndpoint implements SeatInterface
{
    /**
     * Function executes blocking seats and determines prices, which is the first step towards purchasing the tickets.
     * If {handle} connection BACK, then both ways ticket is booked. Blocking of seats is valid for 15 minutes; if in
     * this time the booking is not finished by user (by operation POST Ticket), blocking is over/fails.
     * Result of function (object type BlockInfo) contains handle of assigned seats, which are used in following
     * operations and basic information about ticket being created (seat numbers there and back, price, list of
     * required additional user information – i.e. name, ID/passport number, phone).
     *
     * HTTP: POST
     *
     * @param $data
     * @param $urlParams
     *
     * @return mixed
     */
    public function block(SeatDataInterface $data, $urlParams)
    {
        $method    = BaseInterface::POST;
        $endpoint  = SeatInterface::ENDPOINT_SEATBLOCK;
        $urlParams = $urlParams;

        $headers   = $this->getContentTypeJson();
        $headers['Accept'] = 'application/json';
        $headers['Expect'] = '100-continue';

        $options['headers'] = $headers;
        $options['body']    = json_encode($data->asArray());

        return $this->doRequest($method, $endpoint, $urlParams, $options);
    }

    /**
     * Function releases seats blocked operation POST SeatBlock. Client should use this function in case he reserves
     * seats and then decides not to finish the booking.
     *
     * HTTP: DELETE
     *
     * @param string $ticketHandle
     *
     * @return mixed
     */
    public function unblock($ticketHandle)
    {
        $method    = BaseInterface::DELETE;
        $endpoint  = SeatInterface::ENDPOINT_SEATBLOCK;
        $urlParams = [$ticketHandle];
        $options   = [];

        return $this->doRequest($method, $endpoint, $urlParams, $options);

    }
}
