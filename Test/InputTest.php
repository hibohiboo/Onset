<?php
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use Onset\Input;

class InputTest extends TestCase
{
    public function testGet(){
        $_POST = [
            'hoge'=>'fuga',
            'foo'=>[
                'bar'=>'ぬるぽ'
            ]
        ];
        $this->assertEquals('fuga', Input::get('hoge'));
        $this->assertEquals(['bar'=>'ぬるぽ'], Input::get('foo'));
    }

    public function testGetDefaultValue(){
        $this->assertEquals(765, Input::get('hogehoge', 765));
    }

    public function testVaridate(){
        $v = null;
        $this->assertNull(Input::varidate($v));

        $this->assertNull(Input::varidate(''));
        $this->assertEquals('おんせっと', Input::varidate('おんせっと'));
    }
}