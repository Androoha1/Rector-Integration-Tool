<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core\CliAbstraction;

final class Artisan {

    static public function test(): ShellCommand {
        return new ShellCommand('php artisan test')->run();
    }

    static public function migrateFresh(): ShellCommand {
        return new ShellCommand('php artisan migrate:fresh --env=testing')->run();
    }
}