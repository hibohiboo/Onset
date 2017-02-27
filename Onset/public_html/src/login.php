<?php
require_once __DIR__.'/autoload.php';
use Onset;

if(!Util::checkCsrfToken()){
    echo Util::jsonMessage('不正なアクセス', -1);
    exit();
}

$nick = Util::getInput('nick');
$roomName = Util::getInput('roomName');
$password = Util::getInput('password');

if($nick === null || $password === null){
    echo Util::jsonMessage('空欄があります', -1);
    exit();
}

$roomlist = Util::getRoomlist();

if(!$roomlist->isRoomExist($roomName)){
    echo Util::jsonMessage('存在しない部屋です', -1);
    exit();
}

$room = $roomlist->getRoom($roomName);

if(!$room->checkPassword($password)){
    echo Util::jsonMessage('パスワードが違います', -1);
    exit();
}

$_SESSION['onsetRoom'] = $roomName;
echo Util::jsonMessage('ok');