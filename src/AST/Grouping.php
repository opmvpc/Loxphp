<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\AST;

use Opmvpc\Loxphp\Visitor\Visitor;

class Grouping extends Expression
{
    /**
     * @param Expression $expression
    */
    public function __construct(
        private Expression $expression,
    ) {
    }

    public function accept(Visitor $visitor) : bool | int | float | string | object | null
    {
        return $visitor->visitGrouping($this);
    }

    public function getExpression(): Expression
    {
        return $this->expression;
    }
}
