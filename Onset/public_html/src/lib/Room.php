<?php
namespace Onset;

/*
 部屋クラス
*/
class Room implements \IteratorAggregate{

    private $path;
    private $roomlist;

    function __construct($path = \RoomSavepath){
        $this->path = realpath(\RoomSavepath);
        $this->roomlist = json_decode(Util::loadFile($this->path . '/roomlist.json'), true);
    }

    public function getIterator(){
        return $this->roomlist;
    }

    public function isExist($id){
        return isset($this->roomlist[$id]);
    }

    public function find($id, $default = null){
        if(!$this->isExist($id)) return $default;
        return $this->roomlist[$id];
    }

    public function create($name, $pass){
        $this->checkConfigLimit($name);

        $id = uniqid(dechex(mt_rand()));
        $result = $this->createDir($id);
        if(!$result) throw new \RuntimeException('部屋データの初期化に失敗しました');

        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $this->roomlist[$id] = ['name'=>$name, 'pass'=>$hash];
        
        $this->save();
    }

    public function delete($id){
        if(!$this->isExist($id)) throw new \RuntimeException('存在しない部屋です');
        unset($this->roomlist[$id]);
        Util::removeFolder($this->path."/{$id}");
        $this->save();
    }

    public function checkPassword($id, $pass){
        if(!$this->isExist($id)) throw new \RuntimeException('存在しない部屋です');
        $hash = $this->roomlist[$id]['pass'];
        return \password_verify($pass, $hash);
    }

    public function getChatlog($id){
        if(!$this->isExist($id)) throw new \RuntimeException('存在しない部屋です');
        $logPath = $this->path . "/{$id}/log.json";
        return new Chat($logPath);
    }

    public function deleteOldRoom(){
        foreach($this->roomlist as $id => $data){
            if(filemtime($this->path."/{$id}") + \RoomDelTime < time()){
                $this->remove($id);
            }
        }
    }

    private function createDir($id){
        $dirPath = $this->path . "/{$id}/";
        $result = mkdir($dirPath) &&
            file_put_contents($dirPath.'log.json', '[]') &&
            mkdir($dirPath.'connect');
        
        if(!$result) Util::removeFolder($dirPath);
        return $result;
    }

    private function checkConfigLimit($name){
        if(mb_strlen($name) > \MaxRoomName) throw new \RuntimeException('部屋名が長すぎます');
        if(count($this->roomlist) > \RoomLimit) throw new \RuntimeException('部屋数制限いっぱいです');
    }

    private function save(){
        $jsonPath = $this->path . '/roomlist.json';
        file_put_contents($jsonPath, json_encode($this->roomlist), LOCK_EX);
    }
}