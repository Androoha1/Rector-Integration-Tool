<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core\CliAbstraction;

final class ShellCommand {
    private string $command = '';
    private array $output = [];
    private int $result_code = 0;

    public function __construct(string $command) {
        $this->command = $command;
    }
    public function getOutput(): array {
        return $this->output;
    }

    public function run(): self {
        exec($this->command, $this->output, $this->result_code);
        return $this;
    }

    public function succeeded(): bool {
        return $this->result_code === 0;
    }
}