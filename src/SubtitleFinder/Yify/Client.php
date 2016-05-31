<?php

namespace SubtitleFinder\Yify;

class Client
{
    /**
     * @var string
     */
    protected $apiUrl = 'http://api.yifysubtitles.com/subs';

    /**
     * @param $imdb
     * @return SearchResult
     */
    public function search($imdb)
    {
        if (substr($imdb, 0, 2) != 'tt') {
            $imdb = 'tt' . $imdb;
        }
        $response = json_decode(file_get_contents($this->apiUrl . '/' . $imdb));
        return new SearchResult($response);
    }
}
