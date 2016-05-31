<?php

namespace SubtitleFinder\Yify;

class SearchResult
{
    /**
     * @var \stdClass
     */
    protected $response;

    /**
     * @var array
     */
    protected $subtitles = array();

    /**
     * @param \stdClass $response
     */
    public function __construct(\stdClass $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getSubtitles()
    {
        if (empty($this->subtitles)
            && isset($this->response->success)
            && $this->response->success
            && isset($this->response->subs)) {
            foreach ($this->response->subs as $imdb => $items) {
                foreach ($items as $language => $subtitles) {
                    if (!isset($this->subtitles[$language])) {
                        $this->subtitles[$language] = array();
                    }
                    foreach ($subtitles as $subtitle) {
                        $this->subtitles[$language][] = 'http://www.yifysubtitles.com' . $subtitle->url;
                    }
                }
            }
            ksort($this->subtitles);
        }
        return $this->subtitles;
    }
}