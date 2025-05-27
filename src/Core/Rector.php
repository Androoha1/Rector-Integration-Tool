<?php

declare(strict_types=1);

namespace Androoha\RectorIntegrationTool\Core;

use Androoha\RectorIntegrationTool\Core\ShellCommand;

final class Rector {
    private string $command = 'vendor\\bin\\rector ';
    public function __construct(bool $useCache = false) {
        if ($useCache) $this->command .= " --clear-cache";
    }

    public function process(): self {
        $this->command .= " process";
        return $this;
    }

    public function only(string $ruleName): self {
        $this->command .= " --only=$ruleName";
        return $this;
    }

    public function run(): ShellCommand {
        return new ShellCommand($this->command)->run();
    }
}