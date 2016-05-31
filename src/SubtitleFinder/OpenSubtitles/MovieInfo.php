<?php

namespace SubtitleFinder\OpenSubtitles;

class MovieInfo
{
    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getIMDBID()
    {
        return $this->response['MovieImdbID'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->response['MovieName'];
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return intval($this->response['MovieYear']);
    }

    /**
     * @return string
     */
    public function getKind()
    {
        return $this->response['MovieKind'];
    }

    /**
     * @return int
     */
    public function getSeriesSeason()
    {
        return intval($this->response['SeriesSeason']);
    }

    /**
     * @return int
     */
    public function getSeriesEpisode()
    {
        return intval($this->response['SeriesEpisode']);
    }
}
