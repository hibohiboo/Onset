<?php
namespace Onset;
require_once __DIR__.'/../autoload.php';

class Message{

    static function ok($message, $data = []){
        return static::messageJson(1, $message, $data);
    }

    static function err($message, $data = []){
        return static::messageJson(0, $message, $data);
    }

    static function messageJson($code, $message, $data){
        header("Content-Type: application/json; charset=utf-8");
        return json_encode([
            'code'=>$code,
            'message'=>$message,
            'data'=>$data,
        ]);
    }

}
