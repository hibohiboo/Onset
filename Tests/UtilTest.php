<?php
const DEBUG = true;
require_once __DIR__.'/vendor/autoload.php';

class UtilTest extends \PHPUnit\Framework\TestCase{

    public function testVaridate(){
        $this->assertSame(
            \Onset\Util::varidate('  abc    '),
            'abc'
        );
        $this->assertSame(
            \Onset\Util::varidate('null'),
            'null'
        );
        $this->assertSame(
            \Onset\Util::varidate('0'),
            '0'
        );
        $this->assertSame(
            \Onset\Util::varidate('true'),
            'true'
        );
        $this->assertSame(
            \Onset\Util::varidate('false'),
            'false'
        );
        $this->assertSame(
            \Onset\Util::varidate(null),
            null
        );
        $undefVar;
        $this->assertSame(
            \Onset\Util::varidate($undefVar),
            null
        );
        $this->assertSame(
            \Onset\Util::varidate(''),
            null
        );
    }

}