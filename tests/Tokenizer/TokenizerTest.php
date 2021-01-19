<?php

namespace Opmvpc\Loxphp\Tests\Tokenizer;

use Opmvpc\Loxphp\Tokenizer\Tokenizer;
use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{
    public function testScanTokens()
    {
        $tokenizer = new Tokenizer('(){}');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(5, $tokens);
        $this->assertEquals('T_LEFT_PAREN ( ', $tokens[0]->__toString());
        $this->assertEquals('T_RIGHT_PAREN ) ', $tokens[1]->__toString());
        $this->assertEquals('T_LEFT_BRACE { ', $tokens[2]->__toString());
        $this->assertEquals('T_RIGHT_BRACE } ', $tokens[3]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[4]->__toString());
    }
}
