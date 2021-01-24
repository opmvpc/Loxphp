<?php

namespace Opmvpc\Loxphp\Tests;

use Opmvpc\Loxphp\Loxphp;
use PHPUnit\Framework\TestCase;

class LoxphpTest extends TestCase
{
    public function testRunFile()
    {
        Loxphp::runFile(__DIR__ . '/LoxFiles/empty_file.lox');
        $this->assertFalse(Loxphp::$hadError);
        $this->expectOutputString("T_EOF  ". PHP_EOL);
    }

    public function testWrongFile()
    {
        Loxphp::runFile('test.lox');

        $this->assertTrue(Loxphp::$hadError);
        $this->expectOutputString("\033[31mERROR : File does not exist!\n\033[0m");
    }
}
