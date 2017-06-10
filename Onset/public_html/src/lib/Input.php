<?php
namespace Onset;
require_once __DIR__.'/../autoload.php';

class Input{

    static function get($key, $default = null){
        if(!isset($_POST[$key])) return $default;
        return varidate($key, $default);
    }

    static function varidate($value, $default = null){
        if($value == null) return $default;
        $value = trim($value);
        if($value === '') return $default;
        return $value;
    }

}
