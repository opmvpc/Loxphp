<?php


namespace Opmvpc\Loxphp\AST;

use Opmvpc\Loxphp\Visitor\Visitor;

abstract class Expression
{
    abstract public function accept(Visitor $visitor): bool | int | float | string | object | null;
}
