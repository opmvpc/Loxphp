<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\AST;
use Opmvpc\Loxphp\Tokenizer\Token;
use Opmvpc\Loxphp\Visitor\Visitor;

class Unary extends Expression
{
    /**
     * @param Token $operator
     * @param Expression $right
    */
    public function __construct(
        private Token $operator,
        private Expression $right,
    ) {
    }

    public function accept(Visitor $visitor) : bool | int | float | string | object | null
    {
        return $visitor->visitUnary($this);
    }

    public function getOperator(): Token
    {
        return $this->operator;
    }

    public function getRight(): Expression
    {
        return $this->right;
    }
}
