# About
subtitle-finder is a cli tool that helps to download subtitles. Currently supports opensubtitles and yifysubtitles APIs.

# Installation:
```bash
$ composer global require omerucel/subtitle-finder
$ export PATH="$PATH:$HOME/.composer/vendor/bin"
```

# Usage
```bash
$ subtitle-finder --help
Usage:
    subtitle-finder [options]

Options:
    -f, --file[=FILE]  Movie file.
    -l, --lang[=LANG]  Language code. When yify support enabled, language option is useless. [default: all]
    -y, --yify Use yifysubtitles instead of opensubtitles.
    -ua, --user-agent   Registered user-agent for opensubtitles API. [default: OSTestUserAgent]
    -h, --help Display this help message.

Language Codes:
    All: all
    Chinese (simplified): chi
    Chinese (traditional): zht
    English: eng
    Turkish: tur
```

With opensubtitles:
```bash
$ subtitle-finder -f Test.mp4
English
    1) test.2015.1080p.bluray.x264 (ASCII) (IMDB:XYZ)
    2) EeSt.2015.BrRip.720p.WEB-DL.MkvCage (ASCII) (IMDB:XYZ)
Estonian
    3) Test.2015.720p.BluRay.x264-BLOW (CP1257) (IMDB:XYZ)
Spanish
    4) TEsT.2015.BDRip.x264-COCAIN (CP1252) (IMDB:XYZ)
Select subtitle to download: 1
Downloading...
Done!
```

With yify:
```bash
$ subtitle-finder -f Test.mp4 --yify
arabic
    1) http://www.yifysubtitles.com/subtitle-api/test-yify-XYZ.zip
    2) http://www.yifysubtitles.com/subtitle-api/test-yify-XYZ.zip
brazilian-portuguese
    3) http://www.yifysubtitles.com/subtitle-api/test-yify-XYZ.zip
bulgarian
    4) http://www.yifysubtitles.com/subtitle-api/test-yify-XYZ.zip
chinese
    5) http://www.yifysubtitles.com/subtitle-api/test-yify-XYZ.zip
Select subtitle to download: 1
Downloading...
Done!
```
