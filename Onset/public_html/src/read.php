<?php
require_once __DIR__.'/autoload.php';
use Onset\Message;
use Onset\Request;
use Onset\Room;

if(!isset($_SESSION['onsetRoom'])){
    echo Message::err('ログインしてください');
    exit();
}

$roomId = $_SESSION['onsetRoom'];

$req = new Request();
$time = $req->get('time');

if($time === null){
    echo Message::err('不正なアクセス');
    exit();
}

$chatLog = null;
try{
    $chatLog = (new Room())->getChatlog($roomId);
}catch(\RuntimeException $err){
    echo Message::err($err->message);
    exit();
}

$log = $chatlog->getAfterLog($time);

echo Message::ok('ok', $log);
