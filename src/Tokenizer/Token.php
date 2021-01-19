<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\Tokenizer;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Token
{
    public function __construct(
        private string $type,
        private string $lexeme,
        private bool | int | float | string | null $literal,
        private int $line,
    ) {
    }

    public function __toString(): string
    {
        return "{$this->type} {$this->lexeme} {$this->literal}";
    }
}
