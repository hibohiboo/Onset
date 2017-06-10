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
        $this->log[] = $obj;
        file_put_contents($this->path, json_encode($this->log));
    }

}