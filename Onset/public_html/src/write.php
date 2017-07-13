<?php
require_once __DIR__.'/autoload.php';
use Onset\Request;
use Onset\Message;
use Onset\Room;

if(!isset($_SESSION['onsetRoom'])){
    echo Message::err('ログインしてください');
    exit();
}

$roomId = $_SESSION['onsetRoom'];

$req = new Request();
$nick = $req->get('nick');
$system = $req->get('system');
$text = $req->get('text');

if($nick === null || $system === null || $text === null){
    echo Message::err('空欄があります');
    exit();
}

$chat = null;
try{
    $chat = (new Room())->getChatlog($roomId);
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

try{
    $chat->push($chatData);
}catch(\RuntimeException $err){
    echo Message::err($err->message);
    exit();
}

echo Message::ok('ok');
