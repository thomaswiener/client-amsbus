<?php

namespace AmsBusClient\Endpoint;

use AmsBusClient\Endpoint\Interfaces\SeatInterface;

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
    public function block($data, $urlParams)
    {
        // TODO: Implement block() method.
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
        // TODO: Implement unblock() method.
    }
}
