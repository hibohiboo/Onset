<?php
require_once __DIR__.'/autoload.php';
use Onset;

if(!isset($_SESSION['onsetRoom'])){
    echo Util::jsonMessage('ログインしてください', -1);
    exit();
}

$roomName = $_SESSION['onsetRoom'];

$nick = Util::getInput('nick');
$system = Util::getInput('system');
$text = Util::getInput('text');

if($nick === null || $system === null || $text === null){
    echo Util::jsonMessage('空欄があります', -1);
    exit();
}

$roomlist = Roomlist::create();

$room;
try{
    $room = $roomlist->getRoom($room);
}catch(\RuntimeException $err){
    echo Util::jsonMessage($err->getMessage(), -1);
    exit();
}

$diceResult = Util::diceroll($text, $system);

$chatData = (object)[
    'time' => microtime(true),
    'nick' => $nick,
    'text' => $text,
    'dice' => $diceResult,
    'id' => $_SESSION['onsetId']
];

if($room->putChatlog($chatData) === false){
    echo Util::jsonMessage('チャットログへの書き込みに失敗しました', -1);
    exit();
}

echo Util::jsonMessage('ok');
