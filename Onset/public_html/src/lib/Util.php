<?php
namespace Onset;

/*
 Utilクラス
 インスタンス生成関数や、その他細かな関数をまとめる場所
 このクラスが肥大化するのは多少しょうがない感
 ただし、このクラスのインスタンスは作成禁止
*/
class Util{


    /*
     インスタンスは作っちゃだめです
    */
    private function __construct(){
        throw new \LogicException('do not call Autoload::__construct');
    }

    static function loadFile($path){
        $fp = @fopen($path, 'r');
        if(!$fp) return null;
        flock($fp, LOCK_SH);
        $str = '';
        for($str .= fgets($fp); !feof($fp); $str .= fgets($fp));
        return $str;
    }

    static function removeFolder($path){
        if(!is_dir($path)) throw new \LogicException('arg require directory path');
        foreach(scandir($path) as $f){
            if($f === '.' || $f === '..') continue;
            $cur = $path.'/'.$f;
            if(is_dir($cur)) static::removeFolder($cur);
            else unlink($cur);
        }
        rmdir($path);
    }

}