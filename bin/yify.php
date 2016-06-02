<?php

$client = new \SubtitleFinder\OpenSubtitles\Client();
$client->setCacheDir($tmpPath);
$client->setUserAgent($userAgent);
$movieInfo = $client->getMovieInfo($filePath);
if ($movieInfo == null) {
    echo "{$red}Not found!";
    exit;
}
$client = new \SubtitleFinder\Yify\Client();
$result = $client->search($movieInfo->getIMDBID());

if (count($result->getSubtitles()) == 0) {
    echo 'Not found!' . PHP_EOL;
    exit;
}

$idCounter = 0;
$downloadLinks = array();
foreach ($result->getSubtitles() as $languageName => $subtitles) {
    echo $languageName . PHP_EOL;
    foreach ($subtitles as $subtitleUrl) {
        $idCounter++;
        echo "\t" . $idCounter . ') ' . $subtitleUrl . PHP_EOL;
        $downloadLinks[$idCounter] = $subtitleUrl;
    }
}

$selectedId = intval(readline('Select subtitle to download: '));
if (isset($downloadLinks[$selectedId])) {
    echo 'Downloading...' . PHP_EOL;
    $gzContent = file_get_contents($downloadLinks[$selectedId]);
    $zipFilePath = $tmpPath . '/subtitle.zip';
    file_put_contents($zipFilePath, $gzContent);
    $zip = new \ZipArchive();
    if ($zip->open($zipFilePath) === true) {
        $zip->extractTo($tmpPath . '/subtitle');
        $zip->close();
    }
    $files = glob($tmpPath . '/subtitle/*.srt');
    if (count($files) == 1) {
        $subtitleFileInfo = pathinfo($files[0]);
        $filePathInfo = pathinfo($filePath);
        rename(
            $files[0],
            dirname($filePath) . '/' . basename($filePath, '.' . $filePathInfo['extension'])
            . '.' . $subtitleFileInfo['extension']
        );
    }
    echo 'Done!' . PHP_EOL;
}