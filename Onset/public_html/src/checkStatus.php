<?php
require_once(__DIR__.'/core.php');
header('Content-Type: text/plain');

$coreStatusArr = array();
foreach (scandir('./') as $val) {
    if($val == '.' || $val == '..') continue;
    $coreStatusArr[$val] = is_readable($val);
}

foreach ($coreStatusArr as $key => $val) {
    echo $val ? "" : $key."にアクセスできません\n";
}

$url = Onset::getBcdiceUrl();
file_get_contents("http{$s}://{$url}?list=1");
echo strpos($http_response_header[0], '200') !== FALSE ? "ダイスボットの設定は正常です\n" : "ダイスボットにアクセスできません\n";

$roomPath = RoomSavepath;
$roomDirStatus = is_writable($roomPath) && is_readable($roomPath);
$roomlistStatus = is_writable($roomPath) && is_readable($roomPath);
echo $roomDirStatus && $roomlistStatus ? "部屋データの設定は正常です\n" : "部屋データにアクセスできません\n";
