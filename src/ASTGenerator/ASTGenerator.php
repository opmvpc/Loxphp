<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\ASTGenerator;

class ASTGenerator
{
    private Renderer $renderer;

    /**
     * @var ClassTemplate[]
     */
    private array $data;

    /**
     * ASTGenerator constructor.
     */
    public function __construct()
    {
        $this->setImplementation();
        $this->setData();
    }

    public function generateASTClasses(): void
    {
        echo("\nGenerating classes...\n\n");
        foreach ($this->data as $class) {
            $classCode = $this->render($class);
            file_put_contents(__DIR__. "/../AST/{$class->getClassName()}.php", $classCode);
            echo("\33[32m    ✅ ". ClassTemplate::NAMESPACE ."\\". $class->getClassName() ."\n\33[0m");
        }
        echo("\nClasses generated!\n");
    }

    private function setImplementation(): void
    {
        $this->renderer = new PhpRenderer();
    }

    private function setData(): void
    {
        $this->data = [
            new ClassTemplate(
                'Binary',
                [
                    new PropertyTemplate('Expression', 'left'),
                    new PropertyTemplate('Token', 'operator'),
                    new PropertyTemplate('Expression', 'right'),
                ],
                [
                    'Opmvpc\Loxphp\Tokenizer\Token',
                ],
            ),
            new ClassTemplate(
                'Grouping',
                [
                    new PropertyTemplate('Expression', 'expression'),
                ],
            ),
            new ClassTemplate(
                'Literal',
                [
                    new PropertyTemplate('Object', 'value'),
                ],
            ),
            new ClassTemplate(
                'Unary',
                [
                    new PropertyTemplate('Token', 'operator'),
                    new PropertyTemplate('Expression', 'right'),
                ],
                [
                    'Opmvpc\Loxphp\Tokenizer\Token',
                ],
            ),
        ];
    }

    private function render(ClassTemplate $class): string
    {
        $code = $this->renderer->header(ClassTemplate::NAMESPACE, $class->getUse());
        $code .= $this->renderer->class($class->getClassName(), ClassTemplate::EXTENDS);
        $code .= $this->renderer->constructor($class->getProperties());
        $code .= $this->renderer->getters($class->getProperties());
        $code .= $this->renderer->footer();

        return $code;
    }
}
