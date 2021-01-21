<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\AST;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Literal extends Expression
{

    /**
     * @param Object $value
    */
    public function __construct(
        private Object $value,
    ) {
    }

    public function getValue(): Object
    {
        return $this->value;
    }

}
