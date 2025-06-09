<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core\CliAbstraction;

final class Git {
    private string $command = 'git ';
    static public function addAll(): ShellCommand {
        return new ShellCommand('git add .')->run();
    }
    static public function commit(string $message): ShellCommand {
        return new ShellCommand("git commit -m \"" . $message . "\"")->run();
    }

    static public function commitAll(string $message): ShellCommand {
        self::addAll();
        return self::commit($message);
    }

    static function hasChanges(): bool {
        return (new ShellCommand("git status --porcelain")->run()->getOutput() !== []);
    }
    static function clearAllChanges(): void {
        $systemCall = new ShellCommand("git reset --hard HEAD");
        $systemCall->run();
    }

    static public function checkoutNewBranch(string $name): ShellCommand {
        return new ShellCommand("git checkout -b " . $name)->run();
    }
}
