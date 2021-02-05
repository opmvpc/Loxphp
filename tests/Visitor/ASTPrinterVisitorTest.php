<?php

namespace Opmvpc\Loxphp\Tests\Visitor;

use Opmvpc\Loxphp\AST\Literal;
use Opmvpc\Loxphp\AST\Unary;
use Opmvpc\Loxphp\Tokenizer\Token;
use Opmvpc\Loxphp\Tokenizer\TokenType;
use Opmvpc\Loxphp\Visitor\ASTPrinterVisitor;
use PHPUnit\Framework\TestCase;

class ASTPrinterVisitorTest extends TestCase
{
    public function testPrint()
    {
        $expression = new Unary(new Token(TokenType::T_MINUS, '-', null, 1), new Literal(123));

        $result = (new ASTPrinterVisitor())->print($expression);

        $this->assertEquals('(- 123)', $result);
    }
}
