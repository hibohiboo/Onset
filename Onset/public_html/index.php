<?php
require_once(__DIR__.'/src/autoload.php');
use Onset\Room;

$_SESSION['onsetCsrfToken'] = $rand = uniqid(dechex(mt_rand()));

$roomlist = (new Room())->getList();
$welcomeMessage = file_get_contents('welcomeMessage.html');

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Onset!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <script src="js/jquery.min.js"></script>
    <script src="js/onset.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/onset.css">
</head>
<body>
    <div class="container top">
        <h1>Onset!</h1>
        <article><?=$welcomeMessage?></article>
    </div>

    <div id="enter" class="container">
        <div class="onset-form">
            <div class="form-group">
                <input type="text" class="form-control" id="nick" placeholder="名前">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="pass" placeholder="パスワード">
            </div>
            <div id="notice" class="alert-warning"></div>
        </div>

        <p><span class="btn-link" onclick="toggleTopPage()">部屋の作成</span></p>

        <div>
            <p>部屋一覧</p>
            <div class="table-responsive">
                <table class="table table-sm">
                <tr>
                    <th class="roomname">部屋名</th>
                    <th colspan="3">操作</th>
                </tr>
                <?php foreach($roomlist as $id => $data): ?>
                    <tr>
                        <td><?= h($data['name']) ?></td>
                        <td><button onclick="enterRoom('<?= $id ?>')" class="btn btn-primary">入室</button></td>
                        <td><button onclick="removeRoom('<?= $id ?>')" class="btn btn-danger">削除</button></td>
                        <td><button onclick="alert('id:<?= $id ?>')" class="btn btn-info">情報</button></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div id="create" class="container" style="display:none;">

        <div class="onset-form">
            <div class="form-group">
                <input type="text" class="form-control" id="roomName" placeholder="部屋名">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="roomPass" placeholder="パスワード">
            </div>

            <div id="createNotice" class="alert-warning"></div>
            
            <div class="form-group">
                <button class="btn btn-primary" onclick="createRoom()">作成</button>
            </div>
        </div>

        <p><span class="btn-link" onclick="toggleTopPage()" class="button-inline">戻る</span></p>
    </div>
</body>
</html>
