<?php

declare(strict_types=1);

use Androoha\RectorIntegrationTool\Core\ShellCommand;

final class Artisan {
    private string $command = 'php artisan ';

    public function test(): self {
        $this->command .= " test";

        return $this;
    }

    public function run(): ShellCommand {
        return new ShellCommand($this->command)->run();
    }
}