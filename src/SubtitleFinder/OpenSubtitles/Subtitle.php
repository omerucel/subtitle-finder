<?php

namespace SubtitleFinder\OpenSubtitles;

class Subtitle
{
    /**
     * @var array
     */
    protected $item = array();

    /**
     * @var \DateTime
     */
    protected $addedDate;

    /**
     * @param array $item
     */
    public function __construct(array $item = array())
    {
        $this->item = $item;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->item);
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->get('SubFileName');
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return $this->get('SubEncoding');
    }

    /**
     * @return int
     */
    public function getCDNumber()
    {
        return intval($this->get('SubActualCD'));
    }

    /**
     * @return string
     */
    public function getLanguageID()
    {
        return $this->get('SubLanguageID');
    }

    /**
     * @return string
     */
    public function getLanguageName()
    {
        return $this->get('LanguageName');
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->get('SubFormat');
    }

    /**
     * @return \DateTime
     */
    public function getAddedDate()
    {
        if ($this->addedDate == null) {
            $date = $this->get('SubAddDate');
            $this->addedDate = new \DateTime($date);
        }
        return $this->addedDate;
    }

    /**
     * @return string
     */
    public function getMovieReleaseName()
    {
        return $this->get('MovieReleaseName');
    }

    /**
     * @return string
     */
    public function getIMDBID()
    {
        return $this->get('IDMovieImdb');
    }

    /**
     * @return string
     */
    public function getIMDBRating()
    {
        return $this->get('MovieImdbRating');
    }

    /**
     * @return string
     */
    public function getMovieName()
    {
        return $this->get('MovieName');
    }

    /**
     * @return string
     */
    public function getMovieYear()
    {
        return $this->get('MovieYear');
    }

    /**
     * @return string
     */
    public function getDownloadLink()
    {
        return $this->get('SubDownloadLink');
    }

    /**
     * @return string
     */
    public function getZipDownloadLink()
    {
        return $this->get('ZipDownloadLink');
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    protected function get($name, $default = null)
    {
        return isset($this->item[$name]) ? $this->item[$name] : $default;
    }
}
