<?php
namespace Onset;
require_once __DIR__.'/../autoload.php';

/*
 部屋クラス
*/
class Room{

    /*
     コンストラクタ
     引数には部屋データへのパス(絶対パス)を入れてください
    */
    private $dir;
    public function __construct($roomDataDir){
        $this->dir = $roomDataDir;
    }

    /*
     部屋データへのパスを返す(絶対パス)
     一応おいておく
    */
    public function getDir(){
        return realpath($this->dir);
    }

    /*
     部屋の作成
     実際のファイルやフォルダ等を作成する
    */
    public function create($password){
        if(
            !mkdir($this->dir, 0666) ||
            !mkdir($this->dir.'/connect', 0666) ||
            !touch($this->dir.'/log.json') ||
            !touch($this->dir.'/pass.hash')
        ){
            return false;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        file_put_contents($this->dir.'/pass.hash', $hash);
        return true;
    }

    /*
     部屋の削除
     詳しい実装はRoom::removeRecursiveに
    */
    public function remove(){
        $this->removeRecursive($this->dir);
    }

    /*
     再帰的にフォルダを削除する
     フォルダ以外を指定すると死にます
     半ば秘伝のタレと化してるので、何か妙案があれば変える
    */
    private function removeRecursive($path){
        $path = realpath($path).'/';
        $dirArr = scandir($path);
        foreach($dirArr as $child){
            if($child == '.' || $child == '..') continue;
            if(is_dir($path.$child)){
                $this->removeRoomData($path.$child);
                continue;
            }
            if(!unlink($path.$child)) throw new RuntimeException("ファイル".$path.$child."の削除に失敗しました");
        }
        if(!rmdir($path)) throw new RuntimeException("フォルダ".$path."の削除に失敗しました");
    }

    /*
     パスワード認証
     password_verifyを使ってパスワードが正しいかチェックするだけ
     see also http://php.net/manual/ja/function.password-verify.php
    */
    public function checkPassword($password){
        $passhash = trim(file_get_contents($this->dir.'/pass.hash'));
        return password_verify($password, $passhash);
    }

    /*
     指定時間以降のチャットログを返す
     詳しい実装はRoom::linerSearchとかRoom::binarySearchとか
    */
    public function searchChatlog($time){
        $chatLog = json_decode(file_get_contents($this->dir.'/log.json'));
        return static::linerSearch($chatLog, $time);
    }

    /*
     Room::searchChatlogの実実装その１(線形探索)
     テストしやすいようにstaticメソッドにしてます
     正直そこまでコスト高くないので線形探索で十分
    */
    public static function linerSearch(array $chatLog, $time){
        if($time == 0) return $chatLog;
        $point = count($chatLog) - 1;
        $flag = false;
        for(;isset($chatLog[$point]) && $chatLog[$point]->time > $time; $point -= 1) $flag = true;
        if($flag) return array_slice($chatLog, $point+1);
        else return [];
    }

    /*
     Room::searchChatlogの実実装その２(二分探索)
     テストしやすいようにstaticメソッドにしてます
     一応書いたものの、正直線形探索で十分
     念の為おいておきます
    */
    public static function binarySearch(array $chatLog, $time){
        if($time == 0) return $chatLog;
        $point = ceil(count($chatLog) / 2);
        $width = $point;
        while($width > 0){
            if($chatLog[$point]->time < $time) $point += ceil($width / 2);
            if($chatLog[$point]->time > $time) $point -= ceil($width / 2);
            $width = floor($width / 2);
        }
        return array_slice($chatLog, $point+1);
    }

    /*
     チャットを書き込む
     引数にstdClassを受け付けるけど、後々専用クラスを作る可能性あり
    */
    public function putChatlog(stdClass $chat){
        $chatLog = json_decode(file_get_contents($this->dir.'/log.json'));
        $chatLog[] = $chat;
        return file_put_contents($this->dir.'/log.json', json_encode($chatLog));
    }

    //課題
    public function getConnectMember(){
        
    }

}