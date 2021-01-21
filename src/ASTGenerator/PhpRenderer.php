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
        $code = "<?php\n";
        $code .= "\n";
        $code .= "declare(strict_types=1);\n";
        $code .= "\n";
        $code .= "namespace {$nameSpace};\n";
        $code .= "\n";
        $code .= "use JetBrains\PhpStorm\Immutable;\n";

        if ($use !== null) {
            foreach ($use as $import) {
                $code .= "use {$import};\n";
            }
        }

        $code .= "\n";

        return $code;
    }

    public function class(string $className, string $extends): string
    {
        $code = "#[Immutable]\n";
        $code .= "class {$className} extends {$extends}\n";
        $code .= "{\n";
        $code .= "\n";

        return $code;
    }

    /**
     * @param PropertyTemplate[] $properties
     * @return string
     */
    public function constructor(array $properties): string
    {
        $code = "    /**\n";

        foreach ($properties as $property) {
            $code .= "     * @param {$property->getType()} \${$property->getName()}\n";
        }

        $code .= "    */\n";
        $code .= "    public function __construct(\n";

        foreach ($properties as $property) {
            $code .= "        private {$property->getType()} \${$property->getName()},\n";
        }

        $code .= "    ) {\n";
        $code .= "    }\n";
        $code .= "\n";

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
            $code .= "    public function {$getterName}(): {$property->getType()}\n";
            $code .= "    {\n";
            $code .= "        return \$this->{$property->getName()};\n";
            $code .= "    }\n\n";
        }

        return $code;
    }

    public function footer(): string
    {
        return "}\n";
    }
}
