<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core\CliAbstraction;

final class Composer {
    static public function install(): ShellCommand {
        return new ShellCommand("composer install")->run();
    }

    static public function update(): ShellCommand {
        return new ShellCommand("composer update --no-interaction")->run();
    }

    static public function require(array $package, bool $dev = false): ShellCommand {

        return new ShellCommand("composer require " . ($dev ? "--dev " : "") . implode(' ', $package) . " > /dev/null 2>&1")->run();
    }
}