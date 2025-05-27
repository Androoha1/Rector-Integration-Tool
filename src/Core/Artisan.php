<?php

declare(strict_types=1);

namespace Androoha\RectorIntegrationTool\Core;

use Androoha\RectorIntegrationTool\Core\ShellCommand;

final class Artisan {

    static public function test(): ShellCommand {
        return new ShellCommand('php artisan test')->run();
    }
}