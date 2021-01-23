<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\AST;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Grouping extends Expression
{
    /**
     * @param Expression $expression
    */
    public function __construct(
        private Expression $expression,
    ) {
    }

    public function getExpression(): Expression
    {
        return $this->expression;
    }
}
