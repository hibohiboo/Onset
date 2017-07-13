<?php
require_once __DIR__.'/autoload.php';
use Onset\Request;
use Onset\Message;
use Onset\Room;

$req = new Request();
$roomId = $req->get('roomId');
$password = $req->get('password');

if($roomId === null || $password === null){
    echo Message::err('空欄があります');
    exit();
}

try{
    $room = new Room();
    $room->checkPassword($roomId, $password);
    $room->delete($roomId);
}catch(\RuntimeException $err){
    echo Message::err($err->message);
    exit();
}

echo Message::ok('ok');
