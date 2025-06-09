<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core\CliAbstraction;

final class Git {
    static public function addAll(): ShellCommand {
        $shellCommand = new ShellCommand('git add .');
        return $shellCommand->run();
    }

    static public function commit(string $message): ShellCommand {
        $shellCommand = new ShellCommand("git commit -m \"" . $message . "\"");
        return $shellCommand->run();
    }

    static public function commitAll(string $message): ShellCommand {
        self::addAll();
        return self::commit($message);
    }

    static function hasChanges(): bool {
        $shellCommand = new ShellCommand("git status --porcelain");
        return ($shellCommand->run()->getOutput() !== []);
    }

    static function clearAllChanges(): void {
        $systemCall = new ShellCommand("git reset --hard HEAD");
        $systemCall->run();
    }

    static public function checkoutNewBranch(string $name): ShellCommand {
        $shellCommand = new ShellCommand("git checkout -b " . $name);
        return $shellCommand->run();
    }
}