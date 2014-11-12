<?php
/**
 * Created by PhpStorm.
 * User: twiener
 * Date: 11/6/14
 * Time: 1:19 PM
 */

namespace AmsBusClient\Endpoint\Interfaces;

use AmsBusClient\Data\Interfaces\SeatInterface as SeatDataInterface;

interface SeatInterface extends BaseInterface
{
    CONST ENDPOINT_SEATBLOCK = 'seatblock';

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
     * @param SeatDataInterface $data
     * @param array             $urlParams
     *
     * @return mixed
     */
    public function block(SeatDataInterface $data, $urlParams);

    /**
     * Function releases seats blocked operation POST SeatBlock. Client should use this function in case he reserves
     * seats and then decides not to finish the booking.
     *
     * HTTP: DELETE
     *
     * @param $ticketHandle
     *
     * @return mixed
     */
    public function unblock($ticketHandle);
} 