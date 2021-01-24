<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\AST;
use Opmvpc\Loxphp\Visitor\Visitor;

class Literal extends Expression
{
    /**
     * @param Object $value
    */
    public function __construct(
        private Object $value,
    ) {
    }

    public function accept(Visitor $visitor) : bool | int | float | string | object | null
    {
        return $visitor->visitLiteral($this);
    }

    public function getValue(): Object
    {
        return $this->value;
    }
}
