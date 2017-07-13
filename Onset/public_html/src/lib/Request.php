<?php
namespace Onset;

class Request{

    private $params = [];
    function __construct(){
        $this->params = $_POST;
    }

    public function checkCsrfToken(){
        $sessionToken = $_SESSION['onsetCsrfToken'];
        $formToken = $this->params['_csrfToken'];
        return $sessionToken === $formToken;
    }

    public function get($key, $default = null){
        if(!isset($this->params[$key])) return $default;
        if(is_array($this->params[$key])) return $this->params[$key];
        return $this->varidate($this->params[$key], $default);
    }

    private function varidate($value, $default = null){
        if($value == null) return $default;
        $value = trim($value);
        if($value === '') return $default;
        return $value;
    }
}
