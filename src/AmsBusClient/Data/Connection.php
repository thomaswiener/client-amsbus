<?php

namespace AmsBusClient\Data;

use AmsBusClient\Data\Interfaces\ConnectionInterface;

class Connection implements ConnectionInterface
{
    /**
     * @var string
     */
    protected $from;
    /**
     * @var string
     */
    protected $to;
    /**
     * @var \DateTime
     */
    protected $tripDate;
    /**
     * @var int
     */
    protected $maxResult;
   /**
     * @var int
     */
    protected $searchFlags;

    /**
     * Return parameters as array
     *
     * @return mixed
     */
    public function asArray()
    {
        $data = [
            'from'        => $this->getFrom(),
            'to'          => $this->getTo(),
            'dateTime'    => $this->getTripDate()->format('c'),
            'numConn'     => $this->getMaxResult()

        ];

        if ($this->getSearchFlags()) {
            $data['searchFlags'] = $this->getSearchFlags();
        }

        if ($this->getMaxResult()) {
            $data['numConns'] = $this->getMaxResult();
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSearchFlags()
    {
        return $this->searchFlags;
    }

    /**
     * @param mixed $searchFlags
     * @return $this
     */
    public function setSearchFlags($searchFlags)
    {
        $this->searchFlags = $searchFlags;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTripDate()
    {
        return $this->tripDate;
    }

    /**
     * @param mixed $tripDate
     * @return $this
     */
    public function setTripDate(\DateTime $tripDate)
    {
        $this->tripDate = $tripDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxResult()
    {
        return $this->maxResult;
    }

    /**
     * @param int $maxResult
     * @return $this
     */
    public function setMaxResult($maxResult)
    {
        $this->maxResult = $maxResult;

        return $this;
    }
}
