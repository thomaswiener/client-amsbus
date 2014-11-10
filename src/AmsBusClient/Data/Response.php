<?php
/**
 * Author: Thomas Wiener
 * Author Website: http://wiener.io
 * Date: 18/09/14 15:20
 *
 * @category None
 * @package  AmsBusClient\Data
 * @author   Thomas Wiener <wiener.thomas@googlemail.com>
 * @license  rocket internet
 * @link     unknown
 */
namespace AmsBusClient\Data;

/**
 * Class Response
 *
 * @category None
 * @package  AmsBusClient\Data
 * @author   Thomas Wiener <wiener.thomas@googlemail.com>
 * @license  rocket internet
 * @link     unknown
 */
class Response
{
    /**
     * @var
     */
    protected $success;

    /**
     * @var
     */
    protected $data;

    /**
     * @var
     */
    protected $sessionId;

    /**
     * Is response successful
     *
     * @return mixed
     */
    public function isSuccessful()
    {
        return $this->success;
    }

    /**
     * Get Data of response
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data of Response
     *
     * @param mixed $data Data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set Success of response
     *
     * @param boolean $success Success = true, else false
     *
     * @return $this
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get session id
     *
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set session id
     *
     * @param mixed $sessionId
     *
     * @return $this
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }


} 