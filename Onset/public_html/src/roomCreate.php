<?php
require_once __DIR__.'/autoload.php';
use Onset;

$roomName = Util::getInput('roomName');
$password = Util::getInput('password');

if($roomName === null || $password === null){
    echo Util::jsonMessage('空欄があります', -1);
    exit();
}

$roomlist = Util::getRoomlist();

$result;
try{
    $result = $roomlist->createRoom($roomName, $password);
}catch(\RuntimeException $err){
    echo Util::jsonMessage($err->getMessage, -1);
    exit();
}

if(!$result){
    echo Util::jsonMessage('部屋データの作成に失敗しました');
    exit();
}

Util::saveRoomlist($roomlist);

echo Util::jsonMessage('ok');
