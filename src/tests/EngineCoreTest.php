<?php

use PHPUnit\Framework\TestCase;
use Maoshu\Engine\EngineCore;

class EngineCoreTest extends TestCase
{
    public function testHelloWorld()
    {
        $lib = new EngineCore('maoshuapikey', 'php', 'engine', '111222333');
        var_dump($lib->getContentArr());
        $this->assertEquals(201, $lib->getStatus());
    }
}