<?php

require_once(__DIR__.'/config.php');

class Onset
{

    /*
    バリデーション関数
    外からの値はここを通してください
    バグったときはここが原因の可能性が大
    */
    public static function varidate(&$input)
    {
        $val = $input;
        unset($input);
        if($val == null) return false;
        $val = trim($val);
        if($val == "") return false;
        return $val;
    }

    /*
    部屋データを取得する関数
    jsonをデコードしただけのstdClassが返ってきます
    */
    public static function getRoomlist()
    {
        $name = RoomSavepath . 'roomlist';
        if (!file_exists($name)) {
            file_put_contents($name, '{}');
        }
        return json_decode(file_get_contents($name));
    }

    /*
    部屋データを保存する関数
    stdClassを渡してください(配列の場合はobjectでキャスト)
    */
    public static function saveRoomlist(stdClass $roomlist)
    {
        $dir = RoomSavepath;
        $ret = file_put_contents($dir.'roomlist', json_encode($roomlist), LOCK_EX);
        return $ret;
    }

    /*
    フロントへデータを渡すときはこれを使ってください
    statusは、処理成功時は1、処理失敗時は-1を返してください
    */
    public static function jsonMessage($message, $status = 1, $data = [])
    {
        $json = [
            "status"  => $status,
            "message" => $message,
            "data" => $data
        ];
        header('Content-Type: application/json');
        return json_encode($json);
    }

    /*
    ダイスロールをbcdiceで行うコマンド
    通信周りはfile_get_contなので、もっと最適化できそう
    */
    public static function diceroll($text, $sys)
    {
        $url = self::getBcdiceUrl();

        $encordedText = urlencode($text);
        $encordedSys  = urlencode($sys);

        $ret = file_get_contents($url."?text={$encordedText}&sys={$encordedSys}");
        if(trim($ret) == '1' || trim($ret) == 'error'){
            $ret = "";
        }
        return trim(str_replace('onset: ', '', $ret));
    }

    /*
    $_SERVER[]のデータをこねくり回してbcdiceへのURLを抽出する関数
    よく分かんないから、むやみに触ると死にます
    */
    public static function getBcdiceUrl()
    {
        if(BcdiceURL != "") return BcdiceURL;
        $_dir = str_replace("\\", "/", __DIR__);
        $fullPath = preg_replace("/src$/", "", $_dir) . "bcdice/roll.rb";
        $docRoot = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['SCRIPT_FILENAME']);
        $urlPath = str_replace($docRoot, "", $fullPath);
        $procotlName = !isset($_SERVER['HTTPS']) ? 'http://' : 'https://';
        return $procotlName . $_SERVER['SERVER_NAME'] . $urlPath;
    }

    /*
    チャットログを指定時間以降のものだけ切り取る関数(線形探索)
    $timeはUnixTimestampで、0を渡すと処理を行わずに全件返します
    */
    public static function searchLog(array $chatLog, $time){
        if($time == 0) return $chatLog;
        $point = count($chatLog) - 1;
        $flag = false;
        for(;isset($chatLog[$point]) && $chatLog[$point]->time > $time; $point -= 1) $flag = true;
        if($flag) return array_slice($chatLog, $point+1);
        else return [];
    }

    /*
    チャットログを指定時間以降のものだけ切り取る関数(二分探索)
    線形探索だけで十分だったので放置
    */
    private static function binarySearch(array $chatLog, $time){
        $point = floor(count($chatLog) / 2);
        $width = $point;
        while($width > 1){
            if($chatLog[$point]->time < $time) $point += floor($width / 2);
            if($chatLog[$point]->time > $time) $point -= floor($width / 2);
            $width = floor($width / 2);
        }
        return array_slice($chatLog, $point+1);
    }

    /*
    部屋を削除する関数
    $roomPathは、語尾が'/'で終わっているパス名を引数に与えてください
    */
    public static function removeRoomData($roomPath){
        $dirArr = scandir($roomPath);
        foreach($dirArr as $child){
            if($child == '.' || $child == '..') continue;
            if(is_dir($roomPath.$child)){
                self::removeRoomData($roomPath.$child."/");
                continue;
            }
            if(!unlink($roomPath.$child)) throw new Exception("ファイル".$roomPath.$child."の削除に失敗しました");
        }
        if(!rmdir($roomPath)) throw new Exception("フォルダ".$roomPath."の削除に失敗しました");
    }

    /*
    部屋一覧を表示するhtmlを返す関数
    はっきり言ってview側の処理なので、ここにこの関数があるのは設計的にどうなんだろう
    何かいい案があれば教えてくだしあ
    */
    public static function viewRoomlist(array $roomlist){
        $str = '';
        foreach($roomlist as $idx => $roomName){
            $str .= '<div class="form-check">'
            .'<label class="form-check-label room">'
            .'<input type="radio" class="form-check-input" name="room" value="'.$roomName.'">'.$roomName
            .'</label>'
            .'</div>';
        }
        return $str;
    }

}
