<?php
namespace Onset;

class Input{

    static function get($key, $default = null){
        if(!isset($_POST[$key])) return $default;
        if(is_array($_POST[$key])) return $_POST[$key];
        return static::varidate($_POST[$key], $default);
    }

    static function varidate($value, $default = null){
        if($value == null) return $default;
        $value = trim($value);
        if($value === '') return $default;
        return $value;
    }

}
