<?php

namespace RectorIntegrationTool\Core;

use Posternak\Commandeer\Builders\Artisan;
use Posternak\Commandeer\ShellCommand;

final class Tester {
    static public function test(string $projectType): ?ShellCommand {
        if ($projectType === 'laravel') return Artisan::test()->run();
        elseif ($projectType === 'package') return new ShellCommand('php ./vendor/bin/codecept run')->run();

        return null;
    }
}