<?php

namespace AmsBusClient\Data;

class LogEntry
{
    /**
     * @var string
     */
    protected $requestHeader;

    /**
     * @var string
     */
    protected $requestBody;

    /**
     * @var \DateTime
     */
    protected $requestDateTime;

    /**
     * @var string
     */
    protected $responseHeader;

    /**
     * @var string
     */
    protected $responseBody;

    /**
     * @var \DateTime
     */
    protected $responseDateTime;

    /**
     * @param string $requestBody
     *
     * @return $this
     */
    public function setRequestBody($requestBody)
    {
        $this->requestBody = $requestBody;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestBody()
    {
        return $this->requestBody;
    }

    /**
     * @param \DateTime $requestDateTime
     *
     * @return $this
     */
    public function setRequestDateTime($requestDateTime)
    {
        $this->requestDateTime = $requestDateTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRequestDateTime()
    {
        return $this->requestDateTime;
    }

    /**
     * @param string $requestHeader
     *
     * @return $this
     */
    public function setRequestHeader($requestHeader)
    {
        $this->requestHeader = $requestHeader;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestHeader()
    {
        return $this->requestHeader;
    }

    /**
     * @param string $responseBody
     *
     * @return $this
     */
    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @param \DateTime $responseDateTime
     *
     * @return $this
     */
    public function setResponseDateTime($responseDateTime)
    {
        $this->responseDateTime = $responseDateTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getResponseDateTime()
    {
        return $this->responseDateTime;
    }

    /**
     * @param string $responseHeader
     *
     * @return $this
     */
    public function setResponseHeader($responseHeader)
    {
        $this->responseHeader = $responseHeader;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseHeader()
    {
        return $this->responseHeader;
    }

    public function getFormattedLogMessage()
    {
        $logMessage = sprintf("----- Request at %s -----\n", $this->getRequestDateTime()->format('Y-m-d H:i:s'));
        $logMessage .= sprintf("%s\n", $this->getRequestHeader());
        $logMessage .= sprintf("%s\n\n", $this->getRequestBody());
        $logMessage .= sprintf("----- Response at %s -----\n", $this->getResponseDateTime()->format('Y-m-d H:i:s'));
        $logMessage .= sprintf("%s\n", $this->getResponseHeader());
        $logMessage .= sprintf("%s\n\n", $this->getResponseBody());

        return $logMessage;
    }
}
