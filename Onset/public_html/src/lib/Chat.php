<?php

namespace Onset;
require_once __DIR__.'/../autoload.php';

class Chat implements IteratorAggregate{

    private $path = '';
    private $log = [];

    // log.jsonへのパスを引数に
    function __construct($path){
        if(!file_exists($path)) throw new \RuntimeException('ログが見つかりません');
        $this->path = $path;
        $this->log = json_decode(Util::loadFile($path));
    }

    public function getIterator(){
        return $this->log;
    }

    public function getAfterLog($time){
        if($time === 0) return $this->log;
        foreach(array_reverse($this->log) as $idx => $chat){
            if($chat->time < $time) return array_slice($this->log, -$idx);
        }
    }

    public function push($obj){
        if($obj->text > MaxText) throw new \RuntimeException('テキストが長すぎます');
        if($obj->nick > MaxNick) throw new \RuntimeException('ニックネームが長すぎます');
        $this->log[] = $obj;
        file_put_contents($this->path, json_encode($this->log));
    }

    static function getBcdiceUrl(){
        if(BcdiceURL != "") return BcdiceURL;
        $_dir = str_replace("\\", "/", __DIR__);
        $fullPath = preg_replace("/src.+$/", "", $_dir) . "bcdice/roll.rb";
        $docRoot = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['SCRIPT_FILENAME']);
        $urlPath = str_replace($docRoot, "", $fullPath);
        $procotlName = !isset($_SERVER['HTTPS']) ? 'http://' : 'https://';
        return $procotlName . $_SERVER['SERVER_NAME'] . $urlPath;
    }

    static function diceroll($text, $sys){
        $url = static::getBcdiceUrl();
        $encordedText = urlencode($text);
        $encordedSys  = urlencode($sys);
        $ret = file_get_contents($url."?text={$encordedText}&sys={$encordedSys}");
        if(trim($ret) == '1' || trim($ret) == 'error'){
            $ret = "";
        }
        return trim(str_replace('onset: ', '', $ret));
    }

}