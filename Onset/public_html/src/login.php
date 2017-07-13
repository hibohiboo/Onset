<?php
require_once __DIR__.'/autoload.php';
use Onset\Input;
use Onset\Message;
use Onset\Room;

$nick = Input::get('nick');
$roomId = Input::get('roomId');
$password = Input::get('password');

if($nick === null || $roomId === null || $password === null){
    echo Message::err('空欄があります');
    exit();
}

$room = new Room();

if(!$room->isExist($roomId)){
    Message::err('存在しない部屋です');
    exit();
}

if(!$room->checkPassword($roomId, $password)){
    Message::err('パスワードが違います');
    exit();
}

session_regenerate_id(true);
$_SESSION['onsetId'] = dechex(mt_rand());
$_SESSION['onsetRoom'] = $roomId;
echo Message::ok('ok');
