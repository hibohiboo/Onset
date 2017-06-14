<?php
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use Onset\Chat;

class ChatTest extends TestCase{

    public function setup(){
        $this->vPath = vfsStream::setup();
    }

    public function generateRandomChat(){
        $arr = [];
        foreach(range(1, 140, 3) as $v){
            $arr[] = (object)[
                'time'=>$v,
                'nick'=>dechex(mt_rand()),
                'text'=>dechex(mt_rand()).'\n'.dechex(mt_rand()).dechex(mt_rand()),
                'dice'=>'',
                'id'=>dechex(mt_rand()),
            ];
        }
        return $arr;
    }

    public function testGetAfterLog(){
        $mockChat = $this->generateRandomChat();
        $path = $this->vPath->url().'/log';
        file_put_contents($path, json_encode($mockChat));
        $chat = new Chat($path);

        foreach([123, 59, 135] as $time){
            $this->assertGreaterThan($time, $chat->getAfterLog($time)[0]->time);
        }

        $this->assertEmpty($chat->getAfterLog(150));

        $this->assertEquals($mockChat, $chat->getAfterLog(0));
    }

    public function testPush(){
        $path = $this->vPath->url().'/log';
        file_put_contents($path, json_encode([]));
        $chat = new Chat($path);

        define('MaxText', 10);
        define('MaxNick', 10);

        $obj = (object)[
            'time'=>time(),
            'nick'=>'test',
            'text'=>'hogefuga\nfoobar',
            'dice'=>'',
            'id'=>'testId'
        ];
        $chat->push($obj);

        $this->assertEquals([$obj], $chat->getAfterLog(0));

        $obj = (object)[
            'time'=>time(),
            'nick'=>'toooooooooooo long nickname!!!!!',
            'text'=>'hogefuga\nfoobar',
            'dice'=>'',
            'id'=>'testId'
        ];
        try{
            $chat->push($obj);
            $this->fail();
        }catch(\Exception $err){
            $this->assertTrue(true);
        }

        $obj = (object)[
            'time'=>time(),
            'nick'=>'hoge',
            'text'=>'tooooooooooo long text!!!!!!!!!!!!',
            'dice'=>'',
            'id'=>'testId'
        ];
        try{
            $chat->push($obj);
            $this->fail();
        }catch(\Exception $err){
            $this->assertTrue(true);
        }
    }

}