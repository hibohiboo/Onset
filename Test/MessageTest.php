<?php
use PHPUnit\Framework\TestCase;
use Onset\Message;

class MessageTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testOkMessage(){
        $msg = '腹ペコジョゼは今日も定ジョゼ';
        $data = [
            'foo'=>'bar',
            'hoge'=>['春', '夏', '秋', '冬'],
        ];
        $json = Message::ok($msg, $data);
        $obj = json_decode($json, true);

        $this->assertEquals(1, $obj['code']);
        $this->assertEquals($msg, $obj['message']);
        $this->assertEquals($data, $obj['data']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testErrMessage(){
        $msg = '腹ペコジョゼは今日も定ジョゼ';
        $data = [
            'foo'=>'bar',
            'hoge'=>['春', '夏', '秋', '冬'],
        ];
        $json = Message::err($msg, $data);
        $obj = json_decode($json, true);

        $this->assertEquals(0, $obj['code']);
        $this->assertEquals($msg, $obj['message']);
        $this->assertEquals($data, $obj['data']);
    }    
}