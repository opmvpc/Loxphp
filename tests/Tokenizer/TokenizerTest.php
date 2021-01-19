<?php

namespace Opmvpc\Loxphp\Tests\Tokenizer;

use Opmvpc\Loxphp\Loxphp;
use Opmvpc\Loxphp\Tokenizer\Tokenizer;
use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{
    public function testBasicTokens()
    {
        $tokenizer = new Tokenizer('(){},.-+;*=!<>/');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(16, $tokens);
        $this->assertEquals('T_LEFT_PAREN ( ', $tokens[0]->__toString());
        $this->assertEquals('T_RIGHT_PAREN ) ', $tokens[1]->__toString());
        $this->assertEquals('T_LEFT_BRACE { ', $tokens[2]->__toString());
        $this->assertEquals('T_RIGHT_BRACE } ', $tokens[3]->__toString());
        $this->assertEquals('T_COMMA , ', $tokens[4]->__toString());
        $this->assertEquals('T_DOT . ', $tokens[5]->__toString());
        $this->assertEquals('T_MINUS - ', $tokens[6]->__toString());
        $this->assertEquals('T_PLUS + ', $tokens[7]->__toString());
        $this->assertEquals('T_SEMICOLON ; ', $tokens[8]->__toString());
        $this->assertEquals('T_STAR * ', $tokens[9]->__toString());
        $this->assertEquals('T_EQUAL = ', $tokens[10]->__toString());
        $this->assertEquals('T_BANG ! ', $tokens[11]->__toString());
        $this->assertEquals('T_LESS < ', $tokens[12]->__toString());
        $this->assertEquals('T_GREATER > ', $tokens[13]->__toString());
        $this->assertEquals('T_SLASH / ', $tokens[14]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[15]->__toString());
    }

    public function testTwoPartsTokens()
    {
        $tokenizer = new Tokenizer('!===<=>=');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(5, $tokens);
        $this->assertEquals('T_BANG_EQUAL != ', $tokens[0]->__toString());
        $this->assertEquals('T_EQUAL_EQUAL == ', $tokens[1]->__toString());
        $this->assertEquals('T_LESS_EQUAL <= ', $tokens[2]->__toString());
        $this->assertEquals('T_GREATER_EQUAL >= ', $tokens[3]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[4]->__toString());
    }

    public function testMixedBasicsAndTwoPartsTokens()
    {
        $tokenizer = new Tokenizer('!====!!<==');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(8, $tokens);
        $this->assertEquals('T_BANG_EQUAL != ', $tokens[0]->__toString());
        $this->assertEquals('T_EQUAL_EQUAL == ', $tokens[1]->__toString());
        $this->assertEquals('T_EQUAL = ', $tokens[2]->__toString());
        $this->assertEquals('T_BANG ! ', $tokens[3]->__toString());
        $this->assertEquals('T_BANG ! ', $tokens[4]->__toString());
        $this->assertEquals('T_LESS_EQUAL <= ', $tokens[5]->__toString());
        $this->assertEquals('T_EQUAL = ', $tokens[6]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[7]->__toString());
    }

    public function testUnexpectedChar()
    {
        $tokenizer = new Tokenizer('~');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(1, $tokens);
        $this->assertEquals('T_EOF  ', $tokens[0]->__toString());
        $this->assertTrue(Loxphp::$hadError);
    }

    public function testIgnoreSomeChars()
    {
        $tokenizer = new Tokenizer("( )  \t{\n}\n\r");
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(5, $tokens);
        $this->assertEquals('T_LEFT_PAREN ( ', $tokens[0]->__toString());
        $this->assertEquals('T_RIGHT_PAREN ) ', $tokens[1]->__toString());
        $this->assertEquals('T_LEFT_BRACE { ', $tokens[2]->__toString());
        $this->assertEquals('T_RIGHT_BRACE } ', $tokens[3]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[4]->__toString());
    }

    public function testIgnoreComments()
    {
        $tokenizer = new Tokenizer('// comment ');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(1, $tokens);
        $this->assertEquals('T_EOF  ', $tokens[0]->__toString());
    }

    public function testIgnoreCommentsAfterToken()
    {
        $tokenizer = new Tokenizer('() // comment ');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(3, $tokens);
        $this->assertEquals('T_LEFT_PAREN ( ', $tokens[0]->__toString());
        $this->assertEquals('T_RIGHT_PAREN ) ', $tokens[1]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[2]->__toString());
    }

    public function testString()
    {
        $tokenizer = new Tokenizer('"hello world"');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(2, $tokens);
        $this->assertEquals('T_STRING "hello world" hello world', $tokens[0]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[1]->__toString());
    }

    public function testStringWithNl()
    {
        $string = <<<EOT
"hello
world"
EOT;

        $tokenizer = new Tokenizer($string);
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(2, $tokens);
        $this->assertEquals('T_EOF  ', $tokens[1]->__toString());
    }

    public function testUnclosedString()
    {
        $tokenizer = new Tokenizer('"hello');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(1, $tokens);
        $this->assertEquals('T_EOF  ', $tokens[0]->__toString());
        $this->assertTrue(Loxphp::$hadError);
    }

    public function testInt()
    {
        $tokenizer = new Tokenizer('214');
        $tokens = $tokenizer->scanTokens();
        $this->assertCount(2, $tokens);
        $this->assertEquals('T_NUMBER 214 214', $tokens[0]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[1]->__toString());
    }

    public function testFloat()
    {
        $tokenizer = new Tokenizer('2.14');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(2, $tokens);
        $this->assertEquals('T_NUMBER 2.14 2.14', $tokens[0]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[1]->__toString());
    }

    public function testFloatWithoutDecimals()
    {
        $tokenizer = new Tokenizer('2.');
        $tokens = $tokenizer->scanTokens();

        $this->assertCount(3, $tokens);
        $this->assertEquals('T_NUMBER 2 2', $tokens[0]->__toString());
        $this->assertEquals('T_DOT . ', $tokens[1]->__toString());
        $this->assertEquals('T_EOF  ', $tokens[2]->__toString());
    }
}
