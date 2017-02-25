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

if($roomlist->isRoomExist($roomName)){
    echo Util::jsonMessage('すでに存在する部屋名です', -1);
    exit();
}

$result = $roomlist->createRoom($roomName, $password);

if(!$result){
    echo Util::jsonMessage('部屋データの作成に失敗しました');
    exit();
}

Util::saveRoomlist($roomlist);

echo Util::jsonMessage('ok');
