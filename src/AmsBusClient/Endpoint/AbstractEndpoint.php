<?php
/**
 * Author: Thomas Wiener
 * Author Website: http://wiener.io
 * Date: 18/09/14 15:20
 *
 * @category None
 * @package  AmsBusClient
 * @author   Thomas Wiener <wiener.thomas@googlemail.com>
 * @license  rocket internet
 * @link     unknown
 */

namespace AmsBusClient\Endpoint;

use AmsBusClient\Data\Response;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Response as GuzzleResponse;
use stdClass;

/**
 * Class BaseService
 *
 * @category None
 * @package  AmsBusClient
 * @author   Thomas Wiener <wiener.thomas@googlemail.com>
 * @license  rocket internet
 * @link     unknown
 */
abstract class AbstractEndpoint
{
    /**
     * @var \Guzzle\Http\ClientInterface Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param ClientInterface $client The client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Do request
     *
     * @param $method
     * @param $endpoint
     * @param $data
     *
     * @return GuzzleResponse|Response
     */
    protected function doRequest($method, $endpoint, array $urlParams, array $data)
    {
        $response = $this->client->doRequest($method, $endpoint, $urlParams, $data);

        return $this->getResponse($response);
    }

    /**
     * Get the Response
     *
     * @param GuzzleResponse $response Response
     *
     * @return GuzzleResponse|Response
     */
    protected function getResponse($result)
    {
        $response = new Response();
        $response->setSuccess(false);

        if ($result instanceof GuzzleResponse) {
            $body = $result->getBody()->__toString();
            $json = json_decode($body);

            if ($json) {
                $response->setData($json);
                $response->setSuccess(true);
            } else {
                $response->setData($body);
            }
        }

        return $response;
    }

    /**
     * Convert Response to stdClass
     *
     * @param GuzzleResponse $response Response
     *
     * @return mixed
     */
    protected function convertXmlResponseToStdClass(GuzzleResponse $response)
    {
        try {
            $xml = $response->getBody()->__toString();
            $simpleXml = simplexml_load_string($xml);
            $data = json_decode(json_encode($simpleXml));
        } catch (\Exception $ex) {
            return null;
        }

        return $data;
    }

    /**
     * @param $result
     * @return null
     */
    protected function getSessionIdFromResult($result)
    {
        $cookies = $result->cookies;
        $cookieName = 'ASP.NET_SessionId';

        if (isset($cookies[$cookieName]) && isset($cookies[$cookieName][0])) {
            return $cookies[$cookieName][0];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getSessionName()
    {
        return $this->sessionName;
    }

    /**
     * @param string $sessionName
     *
     * @return $this
     */
    public function setSessionName($sessionName)
    {
        $this->sessionName = $sessionName;

        return $this;
    }

    public function getHeaders()
    {
        $headers = [];
        if (isset($_SESSION[$this->sessionName])) {
            $headers  = ['cookies' => [$this->sessionName => $_SESSION[$this->sessionName]]];
        }

        return $headers;
    }

    protected function getResponseFieldName($method)
    {
        return sprintf('%sResult', $method);
    }


} 