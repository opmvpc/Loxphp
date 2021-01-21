<?php

namespace Opmvpc\Loxphp\Tests\ASTGenerator;

use Opmvpc\Loxphp\ASTGenerator\ASTGenerator;
use PHPUnit\Framework\TestCase;

class ASTGeneratorTest extends TestCase
{

    public function testGenerateASTClasses()
    {
        $generator = new ASTGenerator();

        $generator->generateASTClasses();

        $expectedOutputString = <<< EOT

Generating classes...

[32m    ✅ Opmvpc\Loxphp\AST\Binary
[0m[32m    ✅ Opmvpc\Loxphp\AST\Grouping
[0m[32m    ✅ Opmvpc\Loxphp\AST\Literal
[0m[32m    ✅ Opmvpc\Loxphp\AST\Unary
[0m
Classes generated!

EOT;

        $this->expectOutputString($expectedOutputString);
        self::assertFileExists(__DIR__ . "/../../src/AST/Binary.php");
    }

    public function testGeneratedCodeIsWellFormed()
    {
        $expectedPath = __DIR__ . "/ExpectedBinaryClassCode.txt";
        $actualPath = __DIR__ . "/../../src/AST/Binary.php";

        self::assertFileEquals($expectedPath, $actualPath);
    }
}
