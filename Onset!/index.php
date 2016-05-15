<?php
require_once('src/config.php');

$dir = $config['roomSavepath'];
$roomlist = unserialize(file_get_contents($dir."roomlist"));

session_start();
$_SESSION['onset_rand'] = $rand = mt_rand();

$welcomeMessage = file_get_contents('welcomeMessage.txt');

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Onset!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" href="top.css">
</head>
<body>
<div class="contents">
	<div class="header">
		<h1>Onset!</h1>
		<article><?=$welcomeMessage?></article>
		<p><a href="help.html">Onset!ヘルプページ</a></p>
	</div>

	<div class="join">
		<form class="form" action="src/login.php" method="post">
			<div id="input">
				<input class="text" type="text" name="name" placeholder="名前">
				<input class="text" type="password" name="pass" placeholder="パスワード">
				<input class="button" type="submit" value="入室">
			</div>
		</form>

		<button onclick="toggle()">部屋の作成と削除</button>

		<div class="list">
			<p>部屋一覧</p>
			<?php foreach($roomlist as $key => $value) : ?>
				<label class="room" for="">
				<input type="radio" name="room" value="<?=$key?>"><?=$key?>
				</label>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="edit">

		<h2>作成</h2>

		<form action="src/createRoom.php" method="post">
			<input type="text" class="text" name="name" placeholder="部屋名">
			<input type="password" class="text" name="pass" placeholder="パスワード">
			<input type="hidden" name="rand" value="<?=$rand?>">
			<input type="hidden" name="mode" value="create">
			<input type="submit" class="button" value="作成">
		</form>

		<h2>削除</h2>

		<form action="src/deleteRoom.php" method="post">
			<input type="password" class="text" name="pass" placeholder="パスワード">
			<input type="hidden" name="rand" value="<?=$rand?>">
			<input type="hidden" name="mode" value="del">
			<input type="submit" class="button" value="削除">
		</form>
		<div class="list">
			<p>部屋一覧</p>
			<?php foreach($roomlist as $key => $value) : ?>
				<label class="room" for="">
				<input type="radio" name="room" value="<?=$key?>"><?=$key?>
				</label>
			<?php endforeach; ?>
		</div>
		<button onclick="toggle()">入室画面に戻る</button>
	</div>
</div>
</body>
</html>
