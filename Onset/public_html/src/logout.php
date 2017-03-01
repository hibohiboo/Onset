<?php
require_once __DIR__.'/autoload.php';
use Onset;

session_destroy();
Util::jsonMessage('ok');