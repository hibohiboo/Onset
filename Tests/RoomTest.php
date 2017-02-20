<?php
const DEBUG = true;
require_once __DIR__.'/vendor/autoload.php';

class RoomTest extends \PHPUnit\Framework\TestCase{

    private $chatMock;
    public function setUp(){
        $this->chatMock = [
            (object)["time"=>1],
            (object)["time"=>2],
            (object)["time"=>3],
            (object)["time"=>4],
            (object)["time"=>5],
            (object)["time"=>6],
            (object)["time"=>7],
        ];
    }

    public function testLinerSearch(){
        $obj = \Onset\Room::linerSearch($this->chatMock, 0);
        $this->assertSame($obj[0]->time, 1);

        $obj = \Onset\Room::linerSearch($this->chatMock, 5);
        $this->assertSame($obj[0]->time, 6);

        $obj = \Onset\Room::linerSearch($this->chatMock, 2);
        $this->assertSame($obj[0]->time, 3);

        $obj = \Onset\Room::linerSearch($this->chatMock, 7);
        $this->assertSame($obj, []);

    }

    public function testBinarySearch(){
        $obj = \Onset\Room::binarySearch($this->chatMock, 0);
        $this->assertSame($obj[0]->time, 1);

        $obj = \Onset\Room::binarySearch($this->chatMock, 5);
        $this->assertSame($obj[0]->time, 6);

        $obj = \Onset\Room::linerSearch($this->chatMock, 2);
        $this->assertSame($obj[0]->time, 3);

        $obj = \Onset\Room::binarySearch($this->chatMock, 7);
        $this->assertSame($obj, []);

    }

}