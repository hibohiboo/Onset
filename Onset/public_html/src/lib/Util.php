<?php
namespace Onset;
require_once __DIR__.'/../autoload.php';

class Util{

    /*
     入力値($_POSTとか$_GETとか)を安全に取り出す
     無効な値ならすべてnull
     他は文字列で返るので、適宜キャストとかしてください
     Onset!が思った通りに動かないときは、凡ミス除き70%くらいの確率でこれが怪しい
    */
    static function varidate(&$input){
        $val = $input;
        unset($input);
        if($val == null) return null;
        $val = trim($val);
        if($val == "") return null;
        return $val;
    }

    /*
     BCDiceへのURLを返す
     すでに秘伝のタレ(200年発酵)みたいになってる
     よくわからないので、触るときは気をつけて
    */
    static function getBcdiceUrl(){
        if(BcdiceURL != "") return BcdiceURL;
        $_dir = str_replace("\\", "/", __DIR__);
        $fullPath = preg_replace("/src.+$/", "", $_dir) . "bcdice/roll.rb";
        $docRoot = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['SCRIPT_FILENAME']);
        $urlPath = str_replace($docRoot, "", $fullPath);
        $procotlName = !isset($_SERVER['HTTPS']) ? 'http://' : 'https://';
        return $procotlName . $_SERVER['SERVER_NAME'] . $urlPath;
    }

    /*
     フロントとのやり取りのためのJsonを返す
     その名の通り、フロントとやり取りするときはこの関数使ってください
    */
    static function jsonMessage($message, $status = 1, $data = []){
        $json = [
            "status"  => $status,
            "message" => $message,
            "data" => $data
        ];
        header('Content-Type: application/json');
        return json_encode($json);
    }

}