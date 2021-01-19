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

        switch ($char) {
            case '(': $this->addToken(TokenType::T_LEFT_PAREN);

                break;
            case ')': $this->addToken(TokenType::T_RIGHT_PAREN);

                break;
            case '{': $this->addToken(TokenType::T_LEFT_BRACE);

                break;
            case '}': $this->addToken(TokenType::T_RIGHT_BRACE);

                break;
            case ',': $this->addToken(TokenType::T_COMMA);

                break;
            case '.': $this->addToken(TokenType::T_DOT);

                break;
            case '-': $this->addToken(TokenType::T_MINUS);

                break;
            case '+': $this->addToken(TokenType::T_PLUS);

                break;
            case ';': $this->addToken(TokenType::T_SEMICOLON);

                break;
            case '*': $this->addToken(TokenType::T_STAR);

                break;
            case '!': $this->addToken($this->match('=') ? TokenType::T_BANG_EQUAL : TokenType::T_BANG);

                break;
            case '=': $this->addToken($this->match('=') ? TokenType::T_EQUAL_EQUAL : TokenType::T_EQUAL);

                break;
            case '<': $this->addToken($this->match('=') ? TokenType::T_LESS_EQUAL : TokenType::T_LESS);

                break;
            case '>': $this->addToken($this->match('=') ? TokenType::T_GREATER_EQUAL : TokenType::T_GREATER);

                break;
            case '/':
                if ($this->match('/')) {
                    while ($this->peek() !== '\n' && ! $this->isAtEnd()) {
                        $this->advance();
                    }
                } else {
                    $this->addToken(TokenType::T_SLASH);
                }

                break;
            case ' ':
            case "\r":
            case "\t":

                break;
            case "\n":
                $this->line++;
                break;
            case '"': $this->string();

                break;
            default:
                if ($this->isDigit($char)) {
                    $this->number();
                } else {
                    Loxphp::error($this->line, 'Unexpected character.');
                }

                break;
        }
    }

    private function advance(): string
    {
        $this->current++;

        return $this->charAt($this->current - 1);
    }

    private function addToken(string $tokenType, bool | int | float | string $literal = null): void
    {
        $text = substr($this->source, $this->start, $this->current - $this->start);
        $this->tokens[] = new Token($tokenType, $text, $literal, $this->line);
    }

    private function match(string $expected): bool
    {
        if ($this->isAtEnd()) {
            return false;
        }
        if ($this->charAt($this->current) !== $expected) {
            return false;
        }

        $this->current++;

        return true;
    }

    #[Pure]
    private function peek(): string
    {
        if ($this->isAtEnd()) {
            return '\0';
        }

        return $this->charAt($this->current);
    }

    #[Pure]
    private function charAt(int $position): string
    {
        return substr($this->source, $position, 1);
    }

    private function string(): void
    {
        while ($this->peek() !== '"' && ! $this->isAtEnd()) {
            if ($this->peek() === "\n") {
                $this->line++;
            }
            $this->advance();
        }

        if ($this->isAtEnd()) {
            Loxphp::error($this->line, 'Unterminated string.');
            return;
        }

        $this->advance();

        $value = substr($this->source, $this->start + 1, $this->current - 2);
        $this->addToken(TokenType::T_STRING, $value);
    }

    private function isDigit(string $char): bool
    {
        return $char >= 0 && $char <= 9;
    }

    private function number(): void
    {
        while ($this->isDigit($this->peek())) {
            $this->advance();
        }

        if ($this->peek() === '.' && $this->isDigit($this->peekNext())) {
            $this->advance();

            while ($this->isDigit($this->peek())) {
                $this->advance();
            }
        }

        $value = floatval(substr($this->source, $this->start, $this->current));
        $this->addToken(TokenType::T_NUMBER, $value);
    }

    #[Pure]
    private function peekNext(): string
    {
        if ($this->current + 1 >= strlen($this->source)) {
            return '\0';
        }

        return $this->charAt($this->current + 1);
    }
}
