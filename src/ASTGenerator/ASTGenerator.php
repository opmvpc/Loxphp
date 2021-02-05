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
        echo(PHP_EOL ."Generating classes...". PHP_EOL. PHP_EOL);

        $classCode = $this->renderVisitorInterface();
        file_put_contents(__DIR__. "/../Visitor/Visitor.php", $classCode);
        echo("\33[32m    ✅ Opmvpc\Loxphp\Visitor\Visitor" . PHP_EOL ."\33[0m");

        foreach ($this->data as $class) {
            $classCode = $this->render($class);
            file_put_contents(__DIR__. "/../AST/{$class->getClassName()}.php", $classCode);
            echo("\33[32m    ✅ ". ClassTemplate::NAMESPACE ."\\". $class->getClassName() . PHP_EOL ."\33[0m");
        }

        echo(PHP_EOL ."Classes generated!". PHP_EOL);
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
                    'Opmvpc\Loxphp\Visitor\Visitor',
                ],
            ),
            new ClassTemplate(
                'Grouping',
                [
                    new PropertyTemplate('Expression', 'expression'),
                ],
                [
                    'Opmvpc\Loxphp\Visitor\Visitor',
                ],
            ),
            new ClassTemplate(
                'Literal',
                [
                    new PropertyTemplate('float | bool | int | string | null', 'value'),
                ],
                [
                    'Opmvpc\Loxphp\Visitor\Visitor',
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
                    'Opmvpc\Loxphp\Visitor\Visitor',
                ],
            ),
        ];
    }

    private function render(ClassTemplate $class): string
    {
        $code = $this->renderer->header(ClassTemplate::NAMESPACE, $class->getUse());
        $code .= $this->renderer->class($class->getClassName(), ClassTemplate::EXTENDS);
        $code .= $this->renderer->constructor($class->getProperties());
        $code .= $this->renderer->acceptMethod($class->getClassName());
        $code .= $this->renderer->getters($class->getProperties());
        $code .= $this->renderer->footer();

        return $code;
    }

    private function renderVisitorInterface(): string
    {
        $code = <<< EOL
<?php

declare(strict_types=1);

namespace Opmvpc\Loxphp\Visitor;

EOL;

        foreach ($this->data as $type) {
            $code .= PHP_EOL ."use Opmvpc\Loxphp\AST\\{$type->getClassName()};";
        }

        $code .= PHP_EOL . PHP_EOL;
        $code .= "interface Visitor". PHP_EOL;
        $code .= "{";
        foreach ($this->data as $type) {
            $variableName = strtolower($type->getClassName());
            $code .= PHP_EOL. "    public function visit{$type->getClassName()}({$type->getClassName()} \${$variableName}): bool | int | float | string | object | null;". PHP_EOL;
        }
        $code .= $this->renderer->footer();

        return $code;
    }
}
