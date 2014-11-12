<?php
/**
 * Author: Thomas Wiener
 * Author Website: http://wiener.io
 * Date: 08/10/14 17:54
 *
 * @category None
 * @package  Eurolines
 * @author   Thomas Wiener <wiener.thomas@googlemail.com>
 * @license  rocket internet
 * @link     unknown
 */

namespace AmsBusClient;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;

/**
 * Interface ClientInterface
 *
 * @category None
 * @package  Eurolines
 * @author   Thomas Wiener <wiener.thomas@googlemail.com>
 * @license  rocket internet
 * @link     unknown
 */
interface ClientInterface extends GuzzleClientInterface
{
    /**
     * Do Request
     *
     * @param string $method Method of API Endpoint
     * @param $endpoint
     * @param array $urlParams
     * @param array $options
     *
     * @return mixed
     */
    public function doRequest($method, $endpoint, $urlParams = array(), $options = array());

    /**
     * Set Communication Log
     *
     * @param $request
     * @param $response
     * @param \DateTime $requestDateTime
     * @param \DateTime $responseDateTime
     * @return mixed
     */
    public function setCommunicationLog(
        $request,
        $response,
        \DateTime $requestDateTime,
        \DateTime $responseDateTime
    );

    /**
     * Get Communication Log
     *
     * @return mixed
     */
    public function getCommunicationLog();
} 