<?php
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use Onset\Util;

class UtilTest extends TestCase
{
    public function setUp(){
        $this->vPath = vfsStream::setup();
    }

    public function testLoadFile(){
        $str = "テストファイル\nほげほげ";
        $path = $this->vPath->url() . '/testFile';
        file_put_contents($path, $str);
        $this->assertEquals($str, Util::loadFile($path));
    }

    public function testRemoveFolder(){
        $path = $this->vPath->url() . '/testFolder';
        mkdir($path);
        touch($path.'/bar');
        mkdir($path.'/hoge');
        touch($path.'/hoge/fuga');
        Util::removeFolder($path);
        $this->assertTrue($this->vPath->hasChild('testFolder'));
    }

    /**
     * @expectedException LogicException
     */
    public function testRemoveFolderException(){
        Util::removeFolder('fugafuga');
    }

}