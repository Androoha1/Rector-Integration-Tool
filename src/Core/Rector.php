<?php

declare(strict_types=1);

namespace Androoha\RectorIntegrationTool\Core;

use Androoha\RectorIntegrationTool\Core\ShellCommand;

final class Rector {
    static private string $command = 'vendor\\bin\\rector ';

    static public function process(string $specificRule = "", bool $withCache = true, ?string $path = null): ShellCommand {
        $command = self::$command . "process";
        if ($path !== null) $command .= " " . $path;
        if ($specificRule) $command .= " --only=" . $specificRule;
        if (!$withCache) $command .= " --clear-cache";

        return new ShellCommand($command)->run();
    }
}
