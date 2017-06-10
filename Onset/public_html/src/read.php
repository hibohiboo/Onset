<?php
require_once __DIR__.'/autoload.php';
use Onset;

if(!isset($_SESSION['onsetRoom'])){
    echo Message::err('ログインしてください');
    exit();
}

$roomId = $_SESSION['onsetRoom'];

$time = Input::get('time');

if($time === null){
    echo Message::err('不正なアクセス');
    exit();
}

$chatLog = null;
try{
    $chatLog = (new Room($roomId))->getChatlog;
}catch(\RuntimeException $err){
    echo Message::err($err->message);
    exit();
}

$log = $chatlog->getAfterLog($time);

echo Message::ok('ok', $log);
