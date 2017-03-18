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

try{
    $roomlist->removeRoom($roomName, $password);
}catch(\RuntimeException $err){
    echo Util::jsonMessage($err->getMessage(), -1);
    exit();
}

$roomlist->save();
echo Util::jsonMessage('ok');
