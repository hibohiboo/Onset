<?php
require_once __DIR__.'/autoload.php';
use Onset;

if(!isset($_SESSION['onsetRoom'])){
    echo Util::jsonMessage('ログインしてください', -1);
    exit();
}

$roomName = $_SESSION['onsetRoom'];

$time = Util::getInput('time');

if($time === null){
    echo Util::jsonMessage('不正なアクセス', -1);
    exit();
}

$room = Util::getRoomlist()->getRoom($roomName);
$chatlog = $room->searchChatlog($time);

echo Util::jsonMessage('ok', 1, $chatlog);
