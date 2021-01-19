<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\Tokenizer;

class TokenType
{
    const T_LEFT_PAREN = 'T_LEFT_PAREN';
    const T_RIGHT_PAREN = 'T_RIGHT_PAREN';
    const T_LEFT_BRACE = 'T_LEFT_BRACE';
    const T_RIGHT_BRACE = 'T_RIGHT_BRACE';
    const T_COMMA = 'T_COMMA';
    const T_DOT = 'T_DOT';
    const T_MINUS = 'T_MINUS';
    const T_PLUS = 'T_PLUS';
    const T_SEMICOLON = 'T_SEMICOLON';
    const T_SLASH = 'T_SLASH';
    const T_STAR = 'T_STAR';
    const T_BANG = 'T_BANG';
    const T_BANG_EQUAL = 'T_BANG_EQUAL';
    const T_EQUAL = 'T_EQUAL';
    const T_EQUAL_EQUAL = 'T_EQUAL_EQUAL';
    const T_GREATER = 'T_GREATER';
    const T_GREATER_EQUAL = 'T_GREATER_EQUAL';
    const T_LESS = 'T_LESS';
    const T_LESS_EQUAL = 'T_LESS_EQUAL';
    const T_IDENTIFIER = 'T_IDENTIFIER';
    const T_NUMBER = 'T_NUMBER';
    const T_AND = 'T_AND';
    const T_CLASS = 'T_CLASS';
    const T_ELSE = 'T_ELSE';
    const T_FALSE = 'T_FALSE';
    const T_FUN = 'T_FUN';
    const T_FOR = 'T_FOR';
    const T_IF = 'T_IF';
    const T_NIL = 'T_NIL';
    const T_OR = 'T_OR';
    const T_PRINT = 'T_PRINT';
    const T_RETURN = 'T_RETURN';
    const T_SUPER = 'T_SUPER';
    const T_THIS = 'T_THIS';
    const T_TRUE = 'T_TRUE';
    const T_VAR = 'T_VAR';
    const T_WHILE = 'T_WHILE';
    const T_EOF = 'T_EOF';
}
