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

        return new ShellCommand("composer require " . ($dev ? "--dev " : "") . implode(' ', $package) . " > NUL 2>&1")->run();
    }

    static public function updatePackageVersionConstraint(string $composerFilePath, string $packageName, string $newVersionConstraint, bool $dev = false): void {
        $composerJsonFileContent = json_decode(file_get_contents($composerFilePath));
        $requireSection = $dev ? "require-dev" : "require";

        $composerJsonFileContent[$requireSection][$packageName] = $newVersionConstraint;

        $updatedContent = json_encode($composerJsonFileContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($composerFilePath, $updatedContent);
    }
}