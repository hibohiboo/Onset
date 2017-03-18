<?php
namespace Onset;
require_once __DIR__.'/../autoload.php';

class Roomlist{

    /*
     Roomlistオブジェクトを返す関数
     config.phpの設定を元にRoomlistを生成します
     基本的にこの関数を使ってください
    */
    static function create(){
        $path = realpath(RoomSavepath).'/roomlist';
        $obj = json_decode(file_get_contents($path));
        return new static($obj);
    }

    /*
     Roomlistを保存する
    */
    public function save(){
        $path = realpath(RoomSavepath).'/roomlist';
        $json = $this->dumpJson();
        file_put_contents($path, $json);
    }

    /*
     コンストラクタ
     部屋データのstdClassを渡してください
     (想定としては、roomlistをjson_decodeしたものを直接渡す)
    */
    private $rooms;
    public function __construct(\stdClass $roomlist){
        $this->rooms = $roomlist;
    }

    /*
     部屋名からRoomクラスを返す
     部屋が存在しない場合はRuntimeExceptionが投げられます
    */
    public function getRoom($name){
        if(!$this->isRoomExist($name)) throw new \RuntimeException('部屋が存在しません');
        return new Room($this->rooms->{$name});
    }

    /*
     部屋が存在するか確かめる
     privateメソッドでも良かったかなと思うけど、念の為publicに
    */
    public function isRoomExist($name){
        return isset($this->rooms->{$name});
    }

    /*
     新しい部屋を作成するクラス
     実際にフォルダを作ったりするのはRoom::create
     すでに存在する部屋名の場合はRuntimeExceptionが投げられます
    */
    public function createRoom($name, $password){
        if($this->isRoomExist($name)) throw new \RuntimeException('すでに存在する部屋名です');
        $path = RoomSavepath . uniqid('/', true);
        $room = new Room($path);
        return $room->create($password);
    }

    /*
     部屋を削除する関数
     パスワードが違うか部屋が存在しない場合はRuntimeExceptionが投げられます
    */
    public function removeRoom($name, $password){
        if(!$this->isRoomExist($name)) throw new \RuntimeException('部屋が存在しません');
        $room = $this->getRoom($name);
        if(!$room->checkPassword()) throw new \RuntimeException('パスワードが違います');
        unset($this->rooms->{$name});
        $room->remove();
    }

    /*
     部屋一覧をjson形式でdumpする
     それだけ
    */
    public function dumpJson(){
        return json_encode($this->rooms);
    }

}