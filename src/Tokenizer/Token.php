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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLexeme(): string
    {
        return $this->lexeme;
    }

    /**
     * @return bool|float|int|string|null
     */
    public function getLiteral(): float | bool | int | string | null
    {
        return $this->literal;
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    public function __toString(): string
    {
        return "{$this->type} {$this->lexeme} {$this->literal}";
    }
}
