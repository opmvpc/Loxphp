<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\Tokenizer;

use JetBrains\PhpStorm\Pure;
use Opmvpc\Loxphp\Loxphp;

class Tokenizer
{
    /**
     * @var array<int, Token>
     */
    private array $tokens = [];

    private int $start = 0;

    private int $current = 0;

    private int $line = 1;

    /**
     * Tokenizer constructor.
     * @param string $source
     */
    public function __construct(
        private string $source,
    ) {
    }

    public function scanTokens() : array
    {
        while (! $this->isAtEnd()) {
            $this->start = $this->current;
            $this->scanToken();
        }

        $this->tokens[] = new Token(TokenType::T_EOF, '', null, $this->line);

        return $this->tokens;
    }

    #[Pure]
    private function isAtEnd(): bool
    {
        return $this->current >= strlen($this->source);
    }

    private function scanToken(): void
    {
        $char = $this->advance();

        $token = match($char) {
            '(' => TokenType::T_LEFT_PAREN,
            ')' => TokenType::T_RIGHT_PAREN,
            '{' => TokenType::T_LEFT_BRACE,
            '}' => TokenType::T_RIGHT_BRACE,
            ',' => TokenType::T_COMMA,
            '.' => TokenType::T_DOT,
            '-' => TokenType::T_MINUS,
            '+' => TokenType::T_PLUS,
            ';' => TokenType::T_SEMICOLON,
            '*' => TokenType::T_STAR,
            default => null,
        };

        if ($token === null) {
            Loxphp::error($this->line, 'Unexpected character.');
        } else {
            $this->addToken($token);
        }
    }

    private function advance(): string
    {
        $this->current++;
        return substr($this->source, $this->current - 1, 1);
    }

    private function addToken(string $tokenType, object $literal = null): void
    {
        $text = substr($this->source, $this->start, $this->current - $this->start);
        $this->tokens[] = new Token($tokenType, $text, $literal, $this->line);
    }
}
