<?php

class Autoload{

    private function __construct(){
        throw new LogicException('do not call Autoload::__construct');
    }

    const dir = __DIR__.'/lib/';
    static function load($namePath){
        $namePath = str_replace('Onset\\', '', $namePath);
        $filePath = str_replace('\\', '/', $namePath);
        include static::dir . $filePath . '.php';
    }

}

spl_autoload_register(['Autoload', 'load']);

if(!file_exists(__DIR__.'/config.php')){
    echo "config.phpがありません";
    exit();
}
require_once(__DIR__.'/config.php');

session_start();