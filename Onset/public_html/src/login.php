<?php
require_once __DIR__.'/autoload.php';
use Onset;

$nick = Util::getInput('nick');
$roomName = Util::getInput('roomName');
$password = Util::getInput('password');

if($nick === null || $password === null){
    echo Util::jsonMessage('空欄があります', -1);
    exit();
}

$roomlist = Roomlist::create();

$room;
try{
    $room = $roomlist->getRoom($roomName);
}catch(RuntimeException $err){
    echo Util::jsonMessage($err->getMessage(), -1);
    exit();
}


if(!$room->checkPassword($password)){
    echo Util::jsonMessage('パスワードが違います', -1);
    exit();
}

$_SESSION['onsetId'] = dechex(mt_rand());
$_SESSION['onsetRoom'] = $roomName;
echo Util::jsonMessage('ok');