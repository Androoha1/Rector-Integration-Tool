<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core\CliAbstraction;

final class Composer {
    static public function install(): ShellCommand {
        $shellCommand = new ShellCommand("composer install");
        return $shellCommand->run();
    }

    static public function update(): ShellCommand {
        $shellCommand = new ShellCommand("composer update --no-interaction");
        return $shellCommand->run();
    }

    static public function require(array $package, bool $dev = false): ShellCommand {
        $shellCommand = new ShellCommand("composer require " . ($dev ? "--dev " : "") . implode(' ', $package) . " > /dev/null 2>&1");
        return $shellCommand->run();
    }
}