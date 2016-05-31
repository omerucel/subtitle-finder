<?php

namespace SubtitleFinder\OpenSubtitles;

class SearchResult
{
    /**
     * @var array
     */
    protected $response = array();

    /**
     * @var array
     */
    protected $subtitles = array();

    /**
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getSubtitles()
    {
        if (empty($this->subtitles) && isset($this->response['data'])) {
            foreach ($this->response['data'] as $item) {
                $subtitle = new Subtitle($item);
                if (!isset($this->subtitles[$subtitle->getLanguageName()])) {
                    $this->subtitles[$subtitle->getLanguageName()] = array();
                }
                $this->subtitles[$subtitle->getLanguageName()][] = $subtitle;
            }
            ksort($this->subtitles);
        }
        return $this->subtitles;
    }
}
