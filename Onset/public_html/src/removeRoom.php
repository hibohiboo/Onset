<?php
require_once __DIR__.'/autoload.php';
use Onset;

$roomId = Input::get('roomId');
$password = Input::get('password');

if($roomId === null || $password === null){
    echo Message::err('空欄があります');
    exit();
}

try{
    $room = new Room($roomId);
    $room->checkPass($password);
    $room->delete();
}catch(\RuntimeException $err){
    echo Message::err($err->message);
    exit();
}

echo Util::jsonMessage('ok');
