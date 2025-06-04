<?php

declare(strict_types=1);

namespace RectorIntegrationTool\Core;

use RectorIntegrationTool\Core\ShellCommand;

final class Artisan {

    static public function test(): ShellCommand {
        return new ShellCommand('php artisan test')->run();
    }
}