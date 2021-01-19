#!/usr/bin/php

<?php

require 'vendor/autoload.php';

use Opmvpc\Loxphp\Loxphp;

if ($argc > 2) {
    echo('Usage: php lox [file]');
    exit(64);
} elseif ($argc === 2) {
    Loxphp::runFile($argv[1]);
} else {
    Loxphp::runPrompt();
}
