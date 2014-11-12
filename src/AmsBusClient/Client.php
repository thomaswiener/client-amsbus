<?php
/**
 * Author: Thomas Wiener
 * Author Website: http://wiener.io
 * Date: 27/08/14 11:42
 */

namespace AmsBusClient;

use AmsBusClient\Data\LogEntry;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Message\RequestInterface;

class Client extends HttpClient implements ClientInterface
{
    protected $logEntry;

    /**
     * @var int Curl Timeout in milli seconds
     */
    protected $curlTimeout;
    protected $url;
    protected $version;
    protected $id;
    protected $sslVerficationEnabled;


    public function __construct($parameters)
    {
        parent::__construct();
        //$this->setSslVerification(false, false, 1);

        $this->url     = $parameters['url'];
        $this->version = $parameters['version'];
        $this->id      = $parameters['id'];
        $this->sslVerficationEnabled = $parameters['sslVerifcationEnabled'];
    }

    /**
     * @param string $method
     * @param $endpoint
     * @param array $urlParams
     * @param array $options
     *
     * @return array
     */
    public function doRequest($method, $endpoint, $urlParams = array(), $options )
    {
        $options['verify'] = $this->sslVerficationEnabled;

        $url     = $this->getEndpointUrl($endpoint, $method, $urlParams);
        $request = $this->createRequest($method, $url, $options);

        $requestDateTime = new \DateTime();
        try {
            $response = $this->send($request);
        } catch (ClientException $ex) {
            $this->printRequestResponseBodies($ex);
        } catch (ServerException $ex) {
            $this->printRequestResponseBodies($ex);
        } catch (RequestException $ex) {
            $this->printRequestResponseBodies($ex);
        }

        #$a = json_encode($response->getBody()->__toString());

        $responseDateTime = new \DateTime();

        $responseBody = '';
        if ($response->getBody()) {
            $responseBody = $response->getBody()->__toString();
        }
        $this->setCommunicationLog(
            $this->getLogString($method, json_encode($options)),
            $this->getLogString($method, $responseBody),
            $requestDateTime,
            $responseDateTime
        );

        return $response;
    }

    /**
     * @param $parameters
     * @return string
     */
    protected function getMethod($parameters)
    {
        if (!in_array('method', $parameters)) {
            return $this->method;
        }

        return $parameters['method'];
    }

    /**
     * @return mixed
     */
    public function getEndpointName()
    {
        return self::ENDPOINT_NAME;
    }

    /**
     * Get Endpoint Url
     *
     * @param $endpoint
     *
     * @return string
     */
    protected function getEndpointUrl($endpoint, $method, array $urlParams)
    {
        array_unshift($urlParams , $this->getId());

        return sprintf('%s%s/%s/%s',
            $this->url,
            $this->version,
            $endpoint,
            implode('/', $urlParams)
        );
    }

    /**
     * Get HTTP Headers Authorization
     *
     * @return array
     */
    protected function getHttpHeaders()
    {
        return array(
            'X-User' => $this->username,
            'X-Password' => $this->password
        );

        /*return [
            sprintf("X-User: %s"    , $this->username),
            sprintf("X-Password: %s", $this->password)
        ];*/
    }

    /**
     * @param array $dataArray
     * @return string
     */
    protected function getEncodedData(array $dataArray)
    {
        $items = [];
        foreach ($dataArray as $field => $value) {
            $items[] = sprintf('%s=%s', $field, $value);
        }

        return implode('&', $items);
    }

    /**
     * @param array $data
     * @return string
     */
    protected function getUrlParameterString(array $data)
    {
        return implode('/', $data);
    }

    /**
     * Set Communication Log
     *
     * @param string    $request          Request
     * @param string    $response         Response
     * @param \DateTime $requestDateTime  Date Time of Request
     * @param \DateTime $responseDateTime Date Time of Response
     *
     * @return $this
     */
    public function setCommunicationLog(
        $request,
        $response,
        \DateTime $requestDateTime,
        \DateTime $responseDateTime
    ) {
        $this->logEntry = new LogEntry();
        $this->logEntry
            ->setRequestBody($request)
            ->setResponseBody($response)
            ->setRequestDateTime($requestDateTime)
            ->setResponseDateTime($responseDateTime);
        return $this;
    }

    /**
     * Get Communication Log
     *
     * @return mixed
     */
    public function getCommunicationLog()
    {
        return $this->logEntry;
    }

    /**
     * Reformat a string to pretty print json
     *
     * @param mixed $data The original JSON String
     *
     * @return string
     */
    protected function prettyPrintJson($data)
    {
        $decoded = null;
        if (is_string($data)) {
            $decoded = json_decode($data);
        }

        if (!is_object($decoded)) {
            $decoded = $data;
        }

        return json_encode($decoded, JSON_PRETTY_PRINT);
    }

    /**
     * @param $method
     * @param $data
     * @return string
     */
    protected function getLogString($method, $data)
    {
        return sprintf(
            '[%s]%s %s',
            $method,
            PHP_EOL,
            $data
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    protected function printRequestResponseBodies($ex)
    {
        $request = $ex->getRequest();
        $response = $ex->getResponse();

        $req = $request->__toString();
        $res = $response->__toString();

        echo "---- Request ---- \n" . $req;
        echo "\n";
        echo "---- Response ---- \n" . $res;
        die();
    }
/*
POST /v1/seatblock/13FE2483-DDE9-48F1-B4D5-CE0ACB6057DF/366069407/0 HTTP/1.1
Host: eshopcv.amsbus.cz:8443
Content-Type: application/json
User-Agent: Guzzle/4.2.3 curl/7.37.1 PHP/5.5.14
Content-Length: 43

{"tariffs":[{"tarCode":"P","numPlaces":1}]}




HTTP/1.1 500 Internal Server Error
Cache-Control: no-cache
Pragma: no-cache
Content-Type: application/json; charset=utf-8
Expires: -1
Server: Microsoft-IIS/7.5
X-AspNet-Version: 4.0.30319
X-Powered-By: ASP.NET
Date: Wed, 12 Nov 2014 10:04:29 GMT
Content-Length: 36

{"Message":"An error has occurred."}

*/
}