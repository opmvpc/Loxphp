<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\ASTGenerator;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class ClassTemplate
{
    public const NAMESPACE = 'Opmvpc\Loxphp\AST';

    public const EXTENDS = 'Expression';

    /**
     * ClassTemplate constructor.
     * @param string $className
     * @param PropertyTemplate[] $properties
     * @param string[]|null $use
     */
    public function __construct(
        private string $className,
        private array $properties,
        private ?array $use = null,
    ) {
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string[]|null
     */
    public function getUse(): ?array
    {
        return $this->use;
    }

    /**
     * @return PropertyTemplate[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

}
