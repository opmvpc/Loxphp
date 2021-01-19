<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp;

use Opmvpc\Loxphp\Tokenizer\Tokenizer;

class Loxphp
{
    public static bool $hadError = false;

    /**
     * @psalm-suppress InvalidArgument
     * @param string $fileName
     */
    public static function runFile(string $fileName): void
    {
        set_error_handler(function (int $severity, string $message, string $file, int $line) {
            try {
                throw new \ErrorException($message, $severity, $severity, $file, $line);
            } catch (\Throwable $th) {
                fwrite(STDERR, 'ERROR : File does not exist!');
            }
        });


        $source = file_get_contents($fileName);
        static::run($source);

        restore_error_handler();

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

    public static function error(int $line, string $message): void
    {
        static::reportError($line, '', $message);
    }

    private static function reportError(int $line, string $where, string $message): void
    {
        fwrite(STDERR, "ERROR at line {$line} in {$where} : {$message}");
        static::$hadError = true;
    }
}
