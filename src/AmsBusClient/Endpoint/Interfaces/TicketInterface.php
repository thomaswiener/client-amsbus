<?php
/**
 * Created by PhpStorm.
 * User: twiener
 * Date: 11/6/14
 * Time: 1:24 PM
 */

namespace AmsBusClient\Endpoint\Interfaces;

interface TicketInterface
{
    CONST ENDPOINT_TICKET         = 'Ticket';
    CONST ENDPOINT_REFUND         = 'Refund1';
    CONST ENDPOINT_REFUND_CONFIRM = 'Refund2';

    /**
     * Finishing of ticket purchase and entering additional user details.
     * If connection handle BACK was entered in BlockSeat function, purchase of both ways ticket is finished. Only
     * the additional details which were requested for that particular connection, must be entered.
     * Information about created tickets (as result of function) contains mainly URL, where PDF ticket can be
     * downloaded. Furthermore transaction code and price of course too.
     *
     * HTTP: POST
     *
     * @param string $ticketHandle
     *
     * @return mixed
     */
    public function create($ticketHandle);

    /**
     * Function allows getting data about sold tickets after purchase (means after POST Ticket operation)
     * (the same answer that POST Ticket returns – i.e. when partner doesn’t get any answer on POST Ticket query).
     * This function is available until 15 minutes after purchase only.
     * In case operation POST Ticket wasn’t finished (or 15 minutes after execution was expired) function returns HTTP status 404 – NotFound.
     *
     * HTTP: GET
     *
     * @param $ticketHandle
     *
     * @return mixed
     */
    public function get($ticketHandle);

    /**
     * Function allows cancelling purchase (means successful operation POST Ticket) without cancellation fee.
     * It is determined for solution of technical problems (i.e. in case the ticket wasn’t able to get downloaded
     * or printed) and its usage can be done within 15 minutes after purchase only. In case operation POST Ticket
     * wasn’t finished (or 15 minutes after execution was expired) function returns HTTP status 404 – NotFound.
     *
     * HTTP: DELETE
     *
     * @param $ticketHandle
     *
     * @return mixed
     */
    public function cancel($ticketHandle);

    /**
     * Functions starts refund operation of ticket – means it is blocking ticket and calculates price for refund.
     * Subsequently, client has to decide in 15 minutes if he finishes the refund (by operation POST Refund2) or
     * refuses (by operation DELETE Refund1) – in this case ticket remains valid. In case client doesn’t make any
     * of these operations in 15 minutes, operation is cancelled and ticket remains valid.
     * In the final structure (RefundInfo), only some data are filled (especially refund amount, handle of operation
     * in progress).
     *
     * HTTP: POST
     *
     * @param string $transCode
     * @param string $operation
     *
     * @return mixed
     */
    public function refund($transCode, $operation);

    /**
     * Function cuts off refund operation (in progress by POST Refund1). User should use this function if he
     * started refund operation and decides not to finish it. Ticket remains valid.
     * This function can be executed in 15 minutes after POST Refund1 only.
     *
     * HTTP: DELETE
     *
     * @param string $refundHandle
     *
     * @return mixed
     */
    public function refundCancel($refundHandle);

    /**
     * Function finishes refund operation – means really makes the ticket invalid and releases that blocked seats.
     * If it was refund of only one direction, there is information about the new (remaining) ticket in the result
     * (RefundInfo). This function can be executed in 15 minutes after POST Refund1 only.
     *
     * HTTP: POST
     *
     * @param string $refundHandle
     *
     * @return mixed
     */
    public function refundConfirm($refundHandle);
}