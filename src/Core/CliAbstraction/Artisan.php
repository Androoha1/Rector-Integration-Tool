<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core\CliAbstraction;

final class Artisan {

    static public function test(): ShellCommand {
        $shellCommand = new ShellCommand('php artisan test');
        return $shellCommand->run();
    }

    static public function migrateFresh(): ShellCommand {
        $shellCommand = new ShellCommand('php artisan migrate:fresh --env=testing');
        return $shellCommand->run();
    }
}