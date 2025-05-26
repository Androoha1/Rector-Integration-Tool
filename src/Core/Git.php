<?php

declare(strict_types=1);

use Androoha\RectorIntegrationTool\Core\ShellCommand;

final class Git {
    private string $command = 'git ';
    public function addAll(): self {
        $this->command .= " add .";
        return $this;
    }
    public function commit(string $message): self {
        $this->command .= "git commit -m \"" . $message . "\"";
        return $this;
    }
    static function hasChanges(): bool {
        $systemCall = new ShellCommand("git status --porcelain");
        $systemCall->run();
        return ($systemCall->getOutput() !== []);
    }
    static function clearAllChanges(): void {
        $systemCall = new ShellCommand("git reset --hard HEAD");
        $systemCall->run();
    }
    public function run(): ShellCommand {
        return new ShellCommand($this->command)->run();
    }
}