<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp;

use Opmvpc\Loxphp\Tokenizer\Tokenizer;

class Loxphp
{
    public static bool $hadError = false;

    /**
     * @param string $fileName
     */
    public static function runFile(string $fileName): void
    {
        if (! file_exists($fileName)) {
            echo("\033[31mERROR : File does not exist!\n\033[0m");
            self::$hadError = true;
        } else {
            $source = file_get_contents($fileName);
            static::run($source);
        }

        if (static::$hadError) {
            exit(65);
        }
    }

    public static function runPrompt(): void
    {
        do {
            echo('>>> ');
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            $trimmedLine = trim($line);
            static::run($trimmedLine);
            fclose($handle);
            static::$hadError = false;
        } while ($trimmedLine != 'quit');
    }

    private static function run(string $source): void
    {
        $tokens = (new Tokenizer($source))->scanTokens();
        foreach ($tokens as $token) {
            echo("{$token}\n");
        }
    }

    public static function error(int $line, string $message, ?string $where = null): void
    {
        static::reportError($line, $message, $where);
    }

    private static function reportError(int $line, string $message, ?string $where = null): void
    {
        echo("\033[31mERROR at line {$line} in {$where} : {$message}\n\033[0m");
        static::$hadError = true;
    }
}
