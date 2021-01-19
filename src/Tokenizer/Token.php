<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\Tokenizer;

class Token
{
    public function __construct(
        private string $type,
        private string $lexeme,
        private ?object $literal,
        private int $line,
    ) {
    }

    public function __toString(): string
    {
        return "{$this->type} {$this->lexeme} {$this->literal?->__toString()}";
    }
}
