<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Rector;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use Rector\Rector\AbstractRector;
use Rector\Contract\Rector\ConfigurableRectorInterface;

final class AddRuleToSkip extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var string[]
     */
    private array $rulesToSkip = [];


    public function configure(array $configuration): void
    {
        $this->rulesToSkip = $configuration;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node->name instanceof Identifier) return null;
        if (! $this->isName($node->name, 'withSkip')) return null;

        if (count($node->args) !== 1) {
            return null;
        }

        $arg = $node->args[0]->value;
        if (! $arg instanceof Array_) return null;

        $existingClassNames = [];
        foreach ($arg->items as $item) {
            if ($item instanceof ArrayItem && $item->value instanceof ClassConstFetch) {
                $existingClassNames[] = $this->getName($item->value->class);
            }
        }

        foreach ($this->rulesToSkip as $ruleClass) {
            if (in_array($ruleClass, $existingClassNames, true)) {
                continue; // already present
            }

            $arg->items[] = new ArrayItem(
                new ClassConstFetch(new Name($ruleClass), 'class')
            );
        }

        return $node;
    }
}