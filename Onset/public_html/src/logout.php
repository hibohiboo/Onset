<?php
require_once __DIR__.'/autoload.php';

session_destroy();
Message::ok('ok');