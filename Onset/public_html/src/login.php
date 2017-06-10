<?php
require_once __DIR__.'/autoload.php';
use Onset;

$nick = Input::get('nick');
$roomId = Input::get('roomId');
$password = Input::get('password');

if($nick === null || $roomId === null || $password === null){
    echo Util::jsonMessage('空欄があります', -1);
    exit();
}

$room = null;
try{
    $room = new Room($roomId);
}catch(\RuntimeException $err){
    Message::err($err->message);
    exit();
}

if(!$room->checkPass($password)){
    Message::err('パスワードが違います');
    exit();
}

session_regenerate_id(true);
$_SESSION['onsetId'] = dechex(mt_rand());
$_SESSION['onsetRoom'] = $roomId;
echo Message::ok('ok');
