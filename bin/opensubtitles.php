<?php

$client = new \SubtitleFinder\OpenSubtitles\Client();
$client->setCacheDir($tmpPath);
$client->setUserAgent($userAgent);
$result = $client->search($filePath, $language);
if (count($result->getSubtitles()) == 0) {
    echo 'Not found!' . PHP_EOL;
    exit;
}

/**
 * @var \SubtitleFinder\OpenSubtitles\Subtitle $subtitle
 */
$idCounter = 0;
$downloadLinks = array();
foreach ($result->getSubtitles() as $languageName => $subtitles) {
    echo $languageName . PHP_EOL;
    foreach ($subtitles as $subtitle) {
        $idCounter++;
        echo "\t" . $idCounter . ') ' . trim($subtitle->getMovieReleaseName())
            . ' (' . $subtitle->getEncoding() . ') (IMDB:' . $subtitle->getIMDBID() . ')' . PHP_EOL;
        $downloadLinks[$idCounter] = $subtitle;
    }
}

$selectedId = intval(readline('Select subtitle to download: '));
if (isset($downloadLinks[$selectedId])) {
    echo 'Downloading...' . PHP_EOL;
    $subtitle = $downloadLinks[$selectedId];
    $gzContent = file_get_contents($subtitle->getDownloadLink());
    $fileContent = gzdecode($gzContent);
    file_put_contents(dirname($filePath) . '/' . basename($filePath) . '.' . $subtitle->getFormat(), $fileContent);
    echo "{$green}Done!\n";
}
