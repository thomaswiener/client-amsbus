<?php
/**
 * Created by PhpStorm.
 * User: twiener
 * Date: 11/9/14
 * Time: 9:05 PM
 */

namespace AmsBusClientTest\Endpoint;

use AmsBusClient\Endpoint\Connection;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    protected $config;

    protected $client;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->config = array(
            'url'                   => 'https://eshopcv.amsbus.cz:8443/',
            'id'                    => 'someid',
            'version'               => 'v1',
            'sslVerifcationEnabled' => false
        );
    }

    public function testConnectionSearch()
    {
        $this->client = $this->getMockedClient(
            $this->returnValue(
                $this->getResponseObjectConnectionSearchSuccess()
            )
        );
        $connectionService = new Connection($this->client);

        $connectionData = new \AmsBusClient\Data\Connection();
        $connectionData
            ->setFrom("A")
            ->setTo("B")
            ->setTripDate(new \DateTime());

        $response = $connectionService->search($connectionData);

        $this->assertTrue($response->isSuccessful());
    }

    public function testConnectionFailure()
    {
        $this->client = $this->getMockedClient(
            $this->returnValue(
                $this->getResponseObjectConnectionSearchError()
            )
        );
        $connectionService = new Connection($this->client);

        $connectionData = new \AmsBusClient\Data\Connection();
        $connectionData
            ->setFrom("A")
            ->setTo("B")
            ->setTripDate(new \DateTime());

        $response = $connectionService->search($connectionData);

        $this->assertTrue($response->isSuccessful());
    }

    #########
    # Helper
    #########

    protected function getMockedClient($will)
    {
        $service = $this->getClient();
        $service
            ->expects($this->any())
            ->method('doRequest')
            ->will($will);

        return $service;
    }

    protected function getClient(array $methods = array())
    {
        return $this->getMockObject('\\AmsBusClient\\Client');
    }

    protected function getMockObject($class, array $methods = array())
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

    protected function getResponseObjectConnectionSearchSuccess()
    {
        return $this->getResponseObject('"{\"handle\":366069397,\"totalConnections\":2,\"connections\":[{\"line\":\"000088\",\"conn\":3,\"fromTime\":\"2014-11-11T09:00:00\",\"fromStop\":\"Praha [*CZ],,\u00daAN Florenc\",\"stand\":\"4\",\"toTime\":\"2014-11-11T13:30:00\",\"toStop\":\"Berlin,,ZOB am Funkturm\",\"km\":363,\"price\":{\"eur\":3296},\"priceRet\":{\"eur\":5957},\"flags\":65801,\"startSale\":\"1970-01-01T00:00:00\",\"carrier\":\"EUROLINES\"},{\"line\":\"000088\",\"conn\":25,\"fromTime\":\"2014-11-11T18:00:00\",\"fromStop\":\"Praha [*CZ],,\u00daAN Florenc\",\"stand\":\"6-7\",\"toTime\":\"2014-11-11T22:15:00\",\"toStop\":\"Berlin,,ZOB am Funkturm\",\"km\":363,\"price\":{\"eur\":3296},\"priceRet\":{\"eur\":5957},\"flags\":65545,\"startSale\":\"1970-01-01T00:00:00\",\"carrier\":\"EUROLINES\"}],\"mpz\":\"D\",\"currency\":1}"');
    }

    protected function getResponseObjectConnectionSearchError()
    {
        return $this->getResponseObject('');
    }

    protected function getResponseObject($data)
    {
        $stream = Stream::factory(json_encode($data));

        return new Response(200, array(), $stream);
    }

}