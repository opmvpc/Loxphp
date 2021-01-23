<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\AST;

use JetBrains\PhpStorm\Immutable;
use Opmvpc\Loxphp\Tokenizer\Token;

#[Immutable]
class Binary extends Expression
{

    /**
     * @param Expression $left
     * @param Token $operator
     * @param Expression $right
    */
    public function __construct(
        private Expression $left,
        private Token $operator,
        private Expression $right,
    ) {
    }

    public function getLeft(): Expression
    {
        return $this->left;
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
