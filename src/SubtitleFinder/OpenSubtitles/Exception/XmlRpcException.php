<?php

namespace SubtitleFinder\OpenSubtitles\Exception;

use Exception;

class XmlRpcException extends \Exception
{
    /**
     * @var array
     */
    protected $response = array();

    /**
     * @param array $response
     * @param Exception|null $previous
     */
    public function __construct($response = array(), Exception $previous = null)
    {
        parent::__construct('xmlrpc error! ' . json_encode($response), 0, $previous);
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getXmlRpcStatus()
    {
        return isset($this->response['status']) ? $this->response['status'] : 'Unknown';
    }
}
