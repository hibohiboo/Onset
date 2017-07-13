<?php
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use Onset\Request;

class RequestTest extends TestCase
{
    public function testGet(){
        $_POST = [
            'hoge'=>'fuga',
            'foo'=>[
                'bar'=>'ぬるぽ'
            ],
            'space'=>'',
            'null'=>null,
        ];
        
        $req = new Request();
        $this->assertEquals('fuga', $req->get('hoge'));
        $this->assertEquals(['bar'=>'ぬるぽ'], $req->get('foo'));
        
        $this->assertNull($req->get('space'));
        $this->assertNull($req->get('null'));
        $this->assertNull($req->get('notExist'));

        $this->assertEquals(765, $req->get('space', 765));
        $this->assertEquals(346, $req->get('null', 346));
        $this->assertEquals(876, $req->get('notExist', 876));
    }

    public function testCheckCsrfToken(){
        $rand = dechex(mt_rand());
        $_POST = ['_csrfToken' => $rand];
        $_SESSION = ['onsetCsrfToken' => $rand];

        $req = new Request();
        $this->assertTrue($req->checkCsrfToken());
        unset($req);

        $_POST['_csrfToken'] = 'invalid token!!!';
        $req = new Request();
        $this->assertFalse($req->checkCsrfToken());
    }

}
