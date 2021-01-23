<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\ASTGenerator;

class PropertyTemplate
{
    /**
     * PropertyTemplate constructor.
     * @param string $type
     * @param string $name
     */
    public function __construct(
        private string $type,
        private string $name,
    ) {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
