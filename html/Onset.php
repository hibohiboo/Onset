<?php
session_start();

if(isset($_SESSION['onset_room']) || isset($_SESSION['onset_key'])){
	header("Location: index.php");
	die();
}else{
	$arg = "\"{$_SESSION['onset_room']}, {$_SESSION['onset_key']}\"";
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Onset!</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.js"></script>
		<script type="text/javascript" src="chat_rw.js"></script>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
	</head>
	<body>

		<form action="src/write.php" method="post">
			<input type="text" id="name" value=<?= $_SESSION['onset_name'] ?>><br>
			<textarea id="text" rows="5" cols="50"></textarea><br>
			<input type="button" value="送信" onclick="send_chat(<?= $arg ?>)">
		</form>



		<br><hr>
		<script>$(document).ready(function(){get_log(<?= $arg ?>);});</script>
		<font size="2">
		<chat><?php echo file_get_contents("../room/{$_SESSION['onset_room']}/xxlogxx.txt"); ?></chat>
		</font>

	</body>
</html>
