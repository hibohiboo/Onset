<?php
require_once __DIR__.'/autoload.php';
use Onset;

if(!isset($_SESSION['onsetRoom'])){
    echo Message::err('ログインしてください');
    exit();
}

$roomId = $_SESSION['onsetRoom'];

$nick = Input::get('nick');
$system = Input::get('system');
$text = Input::get('text');

if($nick === null || $system === null || $text === null){
    echo Message::err('空欄があります');
    exit();
}

$room = null;
try{
    $room = new Room($roomId);
}catch(\RuntimeExceptino $err){
    echo Message::err($err->message);
    exit();
}

$diceResult = Chat::diceroll($text, $sys);

$chatData = (object)[
    'time' => microtime(true),
    'nick' => $nick,
    'text' => $text,
    'dice' => $diceResult,
    'id' => $_SESSION['onsetId']
];

if($room->putChatlog($chatData) === false){
    echo Message::err('チャットログへの書き込みに失敗しました');
    exit();
}

echo Message::ok('ok');
