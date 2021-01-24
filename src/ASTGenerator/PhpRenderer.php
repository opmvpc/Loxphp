<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\ASTGenerator;

class PhpRenderer implements Renderer
{
    /**
     * PhpRenderer constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $nameSpace
     * @param string[]|null $use
     * @return string
     */
    public function header(string $nameSpace, ?array $use): string
    {
        $code = "<?php". PHP_EOL;
        $code .= PHP_EOL;
        $code .= "declare(strict_types=1);". PHP_EOL;
        $code .= PHP_EOL;
        $code .= "namespace {$nameSpace};". PHP_EOL;

        if ($use !== null) {
            foreach ($use as $import) {
                $code .= "use {$import};". PHP_EOL;
            }
        }

        $code .= PHP_EOL;

        return $code;
    }

    public function class(string $className, string $extends): string
    {
        $code = "class {$className} extends {$extends}". PHP_EOL;
        $code .= "{". PHP_EOL;

        return $code;
    }

    /**
     * @param PropertyTemplate[] $properties
     * @return string
     */
    public function constructor(array $properties): string
    {
        $code = "    /**". PHP_EOL;

        foreach ($properties as $property) {
            $code .= "     * @param {$property->getType()} \${$property->getName()}". PHP_EOL;
        }

        $code .= "    */". PHP_EOL;
        $code .= "    public function __construct(". PHP_EOL;

        foreach ($properties as $property) {
            $code .= "        private {$property->getType()} \${$property->getName()},". PHP_EOL;
        }

        $code .= "    ) {". PHP_EOL;
        $code .= "    }". PHP_EOL;

        return $code;
    }

    public function acceptMethod(string $className): string
    {
        $code = PHP_EOL ."    public function accept(Visitor \$visitor) : bool | int | float | string | object | null". PHP_EOL;
        $code .= "    {". PHP_EOL;
        $code .= "        return \$visitor->visit{$className}(\$this);". PHP_EOL;
        $code .= "    }". PHP_EOL;

        return $code;
    }

    /**
     * @param PropertyTemplate[] $properties
     * @return string
     */
    public function getters(array $properties): string
    {
        $code = '';
        foreach ($properties as $property) {
            $getterName = "get". ucfirst($property->getName());
            $code .= PHP_EOL ."    public function {$getterName}(): {$property->getType()}". PHP_EOL;
            $code .= "    {". PHP_EOL;
            $code .= "        return \$this->{$property->getName()};". PHP_EOL;
            $code .= "    }". PHP_EOL;
        }

        return $code;
    }

    public function footer(): string
    {
        return "}". PHP_EOL;
    }
}
