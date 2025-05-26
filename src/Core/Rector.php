<?php

declare(strict_types=1);

namespace Androoha\RectorIntegrationTool\Core;

use Androoha\RectorIntegrationTool\Core\ShellCommand;

final class Rector {
    private bool $useCache = false;
    private string $command = 'vendor\\bin\\rector ';
    public function __construct(bool $useCache = false) {
        $this->useCache = $useCache;
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
        if (!$this->useCache) $this->command .= " --clear-cache";
        return new ShellCommand($this->command)->run();
    }
}