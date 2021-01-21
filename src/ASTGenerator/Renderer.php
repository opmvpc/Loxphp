<?php

declare(strict_types=1);


namespace Opmvpc\Loxphp\ASTGenerator;


interface Renderer
{
    /**
     * @param string $nameSpace
     * @param string[]|null $use
     * @return string
     */
    public function header(string $nameSpace, ?array $use): string;

    public function class(string $className, string $extends): string;

    /**
     * @param PropertyTemplate[] $properties
     * @return string
     */
    public function constructor(array $properties): string;

    /**
     * @param PropertyTemplate[] $properties
     * @return string
     */
    public function getters(array $properties): string;

    public function footer(): string;
}
