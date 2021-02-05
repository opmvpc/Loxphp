<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\AST;

use Opmvpc\Loxphp\Visitor\Visitor;

class Literal extends Expression
{
    /**
     * @param float | bool | int | string | null $value
    */
    public function __construct(
        private float | bool | int | string | null $value,
    ) {
    }

    public function accept(Visitor $visitor) : bool | int | float | string | object | null
    {
        return $visitor->visitLiteral($this);
    }

    public function getValue(): float | bool | int | string | null
    {
        return $this->value;
    }
}
