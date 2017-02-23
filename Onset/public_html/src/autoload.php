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

if(!defined('DEBUG') && !file_exists(__DIR__.'/config.php')) throw new RuntimeException('config.phpが見つかりません');
if(!defined('DEBUG')) require_once(__DIR__.'/config.php');

session_start();