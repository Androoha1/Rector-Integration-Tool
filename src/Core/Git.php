<?php

declare(strict_types=1);

namespace Androoha\RectorIntegrationTool\Core;

use Androoha\RectorIntegrationTool\Core\ShellCommand;

final class Git {
    private string $command = 'git ';
    static public function addAll(): ShellCommand {
        return new ShellCommand('git add .')->run();
    }
    static public function commit(string $message): ShellCommand {
        return new ShellCommand("git commit -m \"" . $message . "\"")->run();
    }
    static function hasChanges(): bool {
        return (new ShellCommand("git status --porcelain")->run()->getOutput() !== []);
    }
    static function clearAllChanges(): void {
        $systemCall = new ShellCommand("git reset --hard HEAD");
        $systemCall->run();
    }
}
