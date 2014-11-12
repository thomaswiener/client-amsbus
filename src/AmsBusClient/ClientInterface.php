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
     * @param array $parameters
     * @param null $body
     * @param null $headers
     *
     * @return mixed
     */
    public function doRequest(
        $method,
        $endpoint,
        $urlParams = array(),
        $options
    );

//    /**
//     * Setup Request
//     *
//     * @param string $method API Method
//     * @param array  $params Parameters
//     *
//     * @return \Guzzle\Http\Message\Request
//     */
//    public function setup($method, $params);

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