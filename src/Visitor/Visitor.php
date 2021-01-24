<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\Visitor;

use Opmvpc\Loxphp\AST\Binary;
use Opmvpc\Loxphp\AST\Grouping;
use Opmvpc\Loxphp\AST\Literal;
use Opmvpc\Loxphp\AST\Unary;

interface Visitor
{
    public function visitBinary(Binary $binary): bool | int | float | string | object | null;

    public function visitGrouping(Grouping $grouping): bool | int | float | string | object | null;

    public function visitLiteral(Literal $literal): bool | int | float | string | object | null;

    public function visitUnary(Unary $unary): bool | int | float | string | object | null;
}
