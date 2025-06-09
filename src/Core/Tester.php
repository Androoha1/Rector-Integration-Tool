<?php

namespace RectorIntegrationTool\Core;

use RectorIntegrationTool\Core\CliAbstraction\Artisan;
use RectorIntegrationTool\Core\CliAbstraction\ShellCommand;

final class Tester {
    static public function test(string $projectType): ?ShellCommand {
        if ($projectType === 'laravel') return Artisan::test();
        elseif ($projectType === 'package') return new ShellCommand('php ./vendor/bin/codecept run')->run();

        return null;
    }
}