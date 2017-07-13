<?php
require_once __DIR__.'/autoload.php';
use Onset\Request;
use Onset\Message;
use Onset\Room;

$req = new Request();
$roomName = $req->get('roomName');
$password = $req->get('password');

if($roomName === null || $password === null){
    echo Message::err('空欄があります');
    exit();
}

try{
    $room = new Room();
    $room->create($roomName, $password);
}catch(\RuntimeException $err){
    echo Message::err($err->message);
    exit();
}

echo Message::ok('ok');
