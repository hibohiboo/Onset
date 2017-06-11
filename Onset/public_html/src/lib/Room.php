<?php
namespace Onset;
require_once __DIR__.'/../autoload.php';

/*
 部屋クラス
*/
class Room{

    public $id = '';
    public $name = '';
    private $passwd = '';

    // 部屋の実データが存在するフォルダへのパス(string)
    private $path = '';

    static function getList(){
        $dir = realpath(RoomSavepath);
        foreach(scandir($dir) as $fname){
            if($fname === '.' || $fname === '..') continue;
            if(is_dir($dir.'/'.$fname)) yield new static($fname);
        }
    }

    static function deleteOldRoom(){
        foreach(scandir(RoomSavepath) as $file){
            $path = realpath(RoomSavepath).'/'.$file;
            if($file === '.' || $file === '..' || is_file($path)) continue;
            if(time() - filemtime($path) > RoomDelTime){

            }
        }
    }

    function __construct($id = ''){
        // 新規作成の場合、新しくフォルダを作成
        if($id === ''){
            if(scandir(RoomSavepath) > RoomLimit+2) throw new \RuntimeException('部屋数制限いっぱいです');
            $this->id = uniqid('', true);
            $this->path = realpath(RoomSavepath).'/'.$id;
            mkdir($this->path);
        }else{ // 読み込みの場合、存在するかチェックしてからデータ読み込み
            $this->path = realpath(RoomSavepath).'/'.$id;
            if(!file_exists($this->path)) throw new \RuntimeException('部屋が存在しません');
            $this->id = $id;
            $obj = json_decode(Util::loadFile($this->path.'/roomdata'));
            $this->name = $obj->name;
            $this->passwd = $obj->passwd;
        }
    }

    public function save(){
        if(mb_strlen($this->name) > MaxRoomName) throw new \RuntimeException('部屋名が長すぎます');
        $data = (Object)[
            'name'=>$this->name,
            'passwd'=>$this->passwd,
        ];
        file_put_contents($this->path.'/roomdata', $data, LOCK_EX);
    }

    public function delete(){
        Util::removeFolder($this->path);
    }

    public function getChatlog(){
        return new Chat($this->path.'/log.json');
    }

    public function checkPass($password) : bool{
        return password_verify($password, $this->passwd);
    }

    public function setPassword($pass){
        $this->passwd = password_hash($pass, PASSWORD_DEFAULT);
    }

}