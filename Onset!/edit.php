<?php
      session_start();
      $rand = mt_rand();
      $_SESSION['onset_rand'] = $rand;

      $roomlist = scandir('room');
            //カレントディレクトリと一つ上のディレクトリを消去
      foreach($roomlist as $key => $value){
      	if($value == "." || $value == ".."){
      		unset($roomlist[$key]);
      	}
      }
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Onset! 部屋の作成/削除</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.js"></script>
            <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<link rel="stylesheet" href="css.css">
	</head>

      <body>
            <div class="pure-g"><div class="pure-u-1-5"></div>
            <div class="pure-u-2-5">

            <p><h3>作成</h3><br>

            <form action="src/roomedit.php" method="post" class="pure-form-stacked">
                  ルーム名<input type="text" name="name"><br>
                  パスワード<input type="password" name="pass"><br>

                  <input type="hidden" name="rand" value="<?= $rand ?>">
                  <input type="hidden" name="mode" value="create">

                  <input type="submit" value="作成" class="pure-button">
            </form></p>
            <br>

            <p><h3>削除</h3><br>

                  <form action="src/roomedit.php" method="post" class="pure-form-stacked">

                  <?php
                  if($roomlist[2] == NULL){
                       echo "部屋がありません<br>";
                 }else{
                       foreach($roomlist as $value){
                              echo "<input type=\"radio\" name=\"name\" value=\"{$value}\">{$value}";
                              echo "<br>";
                       }
                 }
                 ?>

                部屋のパスワード<input type="password" name="pass"><br>

                 <input type="hidden" name="rand" value="<?= $rand ?>">
                 <input type="hidden" name="mode" value="del">

                 <input type="submit" value="削除" class="pure-button">

           </form></p>

</div><div class="pure-u-1-5"></div></div>
</body></html>
