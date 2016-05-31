<?php

namespace SubtitleFinder\OpenSubtitles;

use SubtitleFinder\OpenSubtitles\Exception\TokenException;
use SubtitleFinder\OpenSubtitles\Exception\XmlRpcException;

class Client
{
    const API_URL = 'http://api.opensubtitles.org/xml-rpc';
    protected $username = '';
    protected $password = '';
    protected $userAgent = 'OSTestUserAgent';
    protected $token = null;
    protected $cacheDir = null;

    /**
     * @throws TokenException
     */
    protected function login()
    {
        if ($this->token != null) {
            return;
        }
        if ($this->cacheDir != null && is_file($this->getCacheFile())) {
            $this->token = file_get_contents($this->getCacheFile());
            return;
        }
        $params = array($this->username, $this->password, 'eng', $this->userAgent);
        $response = $this->request('LogIn', $params);
        $this->checkResponse($response);
        $this->token = $response['token'];
        if ($this->cacheDir != null) {
            file_put_contents($this->getCacheFile(), $this->token);
        }
    }

    /**
     * @param $filePath
     * @param string $lang
     * @return SearchResult
     * @throws TokenException
     * @throws XmlRpcException
     */
    public function search($filePath, $lang = 'eng')
    {
        try {
            return $this->trySearch($filePath, $lang);
        } catch (TokenException $exception) {
            $this->cleanToken();
            return $this->trySearch($filePath, $lang);
        }
    }

    /**
     * @param $filePath
     * @param $lang
     * @return SearchResult
     * @throws TokenException
     * @throws XmlRpcException
     * @throws \Exception
     */
    protected function trySearch($filePath, $lang)
    {
        $params = array(
            $this->getToken(),
            array(
                array(
                    'sublanguageid' => $lang,
                    'moviehash' => VideoHash::calculateFromFile($filePath),
                    'moviebytesize' => filesize($filePath)
                )
            )
        );
        $response = $this->request('SearchSubtitles', $params);
        $this->checkResponse($response);
        return new SearchResult($response);
    }

    /**
     * @param $filePath
     * @return MovieInfo
     * @throws TokenException
     * @throws XmlRpcException
     * @throws \Exception
     */
    public function getMovieInfo($filePath)
    {
        try {
            return $this->tryGetMovieInfo($filePath);
        } catch (TokenException $exception) {
            $this->cleanToken();
            return $this->tryGetMovieInfo($filePath);
        }
    }

    /**
     * @param $filePath
     * @return null|MovieInfo
     * @throws TokenException
     * @throws XmlRpcException
     * @throws \Exception
     */
    protected function tryGetMovieInfo($filePath)
    {
        $hash = VideoHash::calculateFromFile($filePath);
        $params = array($this->getToken(), array($hash));
        $response = $this->request('CheckMovieHash2', $params);
        $this->checkResponse($response);
        if (isset($response['data']) && isset($response['data'][$hash])) {
            return new MovieInfo($response['data'][$hash][0]);
        }
        return null;
    }

    /**
     * @param $response
     * @throws TokenException
     * @throws XmlRpcException
     */
    protected function checkResponse($response)
    {
        if (($response && xmlrpc_is_fault($response))) {
            throw new XmlRpcException($response);
        } else {
            if ($this->isWrongStatus($response)) {
                throw new TokenException($response);
            }
        }
    }

    /**
     * @param $method
     * @param array $params
     * @return array
     */
    public function request($method, array $params = array())
    {
        $request = xmlrpc_encode_request($method, $params);
        $context  = stream_context_create(
            array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => 'Content-Type: text/xml',
                    'content' => $request
                )
            )
        );
        $file = file_get_contents(static::API_URL, false, $context);
        $response = xmlrpc_decode($file);
        return $response;
    }

    /**
     * @param $response
     * @return bool
     */
    private function isWrongStatus($response)
    {
        return isset($response['status']) && $response['status'] != '200 OK';
    }

    /**
     * @return mixed
     * @throws TokenException
     */
    protected function getToken()
    {
        if ($this->token == null) {
            $this->login();
        }
        return $this->token;
    }

    protected function cleanToken()
    {
        $this->token = null;
        if ($this->cacheDir != null) {
            unlink($this->getCacheFile());
        }
    }

    /**
     * @return string
     */
    public function getCacheFile()
    {
        return realpath($this->cacheDir) . '/token.txt';
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @param null $cacheDir
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }
}
