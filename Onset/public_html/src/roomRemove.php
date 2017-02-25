<?php
require_once __DIR__.'/autoload.php';
use Onset;

if(!Util::checkCsrfToken()){
    echo Util::jsonMessage('不正なアクセス', -1);
    exit();
}

$roomlist = Util::getRoomlist();

$roomName = Util::getInput('roomName');
$password = Util::getInput('password');

if($roomName === null || $password === null){
    echo Util::jsonMessage('空欄があります', -1);
    exit();
}

if(!$roomlist->isRoomExist($roomName)){
    echo Util::jsonMessage('存在しない部屋名です', -1);
    exit();
}

try{
    $roomlist->removeRoom();
}catch(\RuntimeException $err){
    echo Util::jsonMessage($err->getMessage(), -1);
    exit();
}

Util::saveRoomlist($roomlist);
echo Util::jsonMessage('ok');
