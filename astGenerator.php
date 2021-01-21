<?php

/**
 * Run this script to generate AST classes
 *
 * usage: php astGenerator.php
 */

require 'vendor/autoload.php';

use Opmvpc\Loxphp\ASTGenerator\ASTGenerator;

(new ASTGenerator())->generateASTClasses();
