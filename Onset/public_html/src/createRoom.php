<?php
require_once __DIR__.'/autoload.php';
use Onset;

$roomName = Input::get('roomName');
$password = Input::get('password');

if($roomName === null || $password === null){
    echo Message::err('空欄があります');
    exit();
}

try{
    $room = new Room();
    $room->name = $roomName;
    $room->setPassword($password);
    $room->save();
}catch(\RuntimeException $err){
    echo Message::err($err->message);
    exit();
}

echo Message::ok('ok');
