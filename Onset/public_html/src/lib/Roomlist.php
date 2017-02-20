<?php
namespace Onset;
require_once __DIR__.'/../autoload.php';

class Roomlist{

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
     それだけ
    */
    public function getRoom($name){
        if(!$this->isRoomExist($name)) throw new RuntimeException('部屋が存在しません');
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
    */
    public function createRoom($name, $password){
        if($this->isRoomExist($name)) LogicException('alrady exist room');
        $path = RoomSavepath . uniqid('/', true);
        $room = new Room($path);
        return $room->create($password);
    }

    public function removeRoom($name){
        if(!$this->isRoomExist($name)) LogicException('room not found');
        $this->getRoom($name)->remove();
    }

    /*
     部屋一覧をjson形式でdumpする
     それだけ
    */
    public function dumpJson(){
        return json_encode($this->rooms);
    }

}