<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Androoha\RectorIntegrationTool\Rector\AddRuleToSkip;

$rulesToSkip = require __DIR__ . '\\temp\\failedRules-' . getenv('PROJECT_NAME') . ".php";

return RectorConfig::configure()
    ->withImportNames(
        importShortClasses: false,
        removeUnusedImports: true
    )
    ->withPaths([])
    ->withConfiguredRule(AddRuleToSkip::class, $rulesToSkip);
