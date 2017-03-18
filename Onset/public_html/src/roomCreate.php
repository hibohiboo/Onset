<?php
require_once __DIR__.'/autoload.php';
use Onset;

$roomName = Util::getInput('roomName');
$password = Util::getInput('password');

if($roomName === null || $password === null){
    echo Util::jsonMessage('空欄があります', -1);
    exit();
}

$roomlist = Roomlist::create();

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

$roomlist->save();

echo Util::jsonMessage('ok');
