<?php


namespace Opmvpc\Loxphp\Visitor;

use JetBrains\PhpStorm\Pure;
use Opmvpc\Loxphp\AST\Binary;
use Opmvpc\Loxphp\AST\Expression;
use Opmvpc\Loxphp\AST\Grouping;
use Opmvpc\Loxphp\AST\Literal;
use Opmvpc\Loxphp\AST\Unary;

class ASTPrinterVisitor implements Visitor
{
    public function print(Expression $expression): bool | int | float | string | object | null
    {
        return $expression->accept($this);
    }

    public function visitBinary(Binary $binary): bool | int | float | string | object | null
    {
        return $this->parenthesize($binary->getOperator()->getLexeme(), $binary->getLeft(), $binary->getRight());
    }

    public function visitGrouping(Grouping $grouping): bool | int | float | string | object | null
    {
        return $this->parenthesize('group', $grouping->getExpression());
    }

    #[Pure]
    public function visitLiteral(Literal $literal): bool | int | float | string | object | null
    {
        if ($literal->getValue() === null) {
            return 'nil';
        }

        return $literal->getValue();
    }

    public function visitUnary(Unary $unary): bool | int | float | string | object | null
    {
        return $this->parenthesize($unary->getOperator()->getLexeme(), $unary->getRight());
    }

    private function parenthesize(string $name, Expression ...$expressions): string
    {
        $string = '(';
        $string .= $name;

        foreach ($expressions as $expression) {
            $string .= ' ';
            $string .= $expression->accept($this);
        }
        $string .= ')';

        return $string;
    }
}
