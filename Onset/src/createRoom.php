<?php

require_once('config.php');
require_once('core.php');

session_start();

if(isIllegalAccess($_POST['rand'], $_SESSION['onset_rand']) === false) {
	echo 'Illegal Access: invalid_access.';
	die();
}

$room = isset($_POST['room']) && $_POST['room'] != "" ? $_POST['room'] : FALSE;
$pass = isset($_POST['pass']) && $_POST['pass'] != "" ? $_POST['pass'] : FALSE;

isSetNameAndPass($room, $pass);
isLongRoomName($room);

$room = htmlspecialchars($room, ENT_QUOTES);
$roomlist = getRoomlist();

if(isExistRoom($roomlist, $room) === true) {
	echo "同名の部屋がすでに存在しています(ブラウザバックをおねがいします)";
	die();
}

if(count($roomlist) >= $config["roomLimit"]){
	echo "これ以上部屋を立てられません、制限いっぱいです";
	die();
}
$dir = $config['roomSavepath'];
$hash = password_hash($pass, PASSWORD_DEFAULT);
unset($pass);			//念の為、平文のパスワードを削除
try{

	$uuid = uniqid("", true);
	mkdir($dir.$uuid) ? "" : function(){throw new Exception();};
	touch("{$dir}{$uuid}/pass.hash") ? "" : function(){throw new Exception();};
	touch("{$dir}{$uuid}/xxlogxx.txt") ? "" : function(){throw new Exception();};
	mkdir("{$dir}{$uuid}/connect") ? "" : function(){throw new Exception();};

	chmod($dir.$uuid, 0777) ? "" : function(){throw new Exception();};
	chmod("{$dir}{$uuid}/pass.hash", 0666) ? "" : function(){throw new Exception();};
	chmod("{$dir}{$uuid}/xxlogxx.txt", 0666) ? "" : function(){throw new Exception();};
	chmod("{$dir}{$uuid}/connect/", 0777) ? "" : function(){throw new Exception();};

	file_put_contents("{$dir}{$uuid}/pass.hash", $hash) ? "" : function(){throw new Exception();};

	$roomlist[$room]["path"] = $uuid;

	file_put_contents($dir."roomlist", serialize($roomlist)) ? "" : function(){throw new Exception();};

} catch(Exception $e) {
		echo "部屋を立てられませんでした。";
}

header("Location: ../index.php");
