<?php

declare(strict_types=1);

$phpUpgradeRules = require __DIR__ . "/RuleSets/phpUpgrade.php";
$deadCodeRules = require __DIR__ . "/RuleSets/deadCode.php";
$codeQualityRules = require __DIR__ . "/RuleSets/codeQuality.php";
$typeDeclarationRules = require __DIR__ . "/RuleSets/typeDeclaration.php";
$namingRules = require __DIR__ . "/RuleSets/naming.php";
$instanceofRules = require __DIR__ . "/RuleSets/instanceof.php";
$earlyReturns = require __DIR__ . "/RuleSets/earlyReturn.php";
$strictBooleans = require __DIR__ . "/RuleSets/strictBooleans.php";
$carbonRules = require __DIR__ . "/RuleSets/carbon.php";
$rectorPresets = require __DIR__ . "/RuleSets/rectorPreset.php";
$phpunitCodeQualityRules = require __DIR__ . "/RuleSets/phpUnitCodeQuality.php";


$config = [
    "projectDir" => "",
    "ruleSets" => [
        "php84-upgrade" => $phpUpgradeRules,
        "dead-code" => $deadCodeRules,
        "code-quality" => $codeQualityRules,
        "type-declaration" => $typeDeclarationRules,
        "naming" => $namingRules,
        "instanceof" => $instanceofRules,
        "early-return" => $earlyReturns,
        "strict-booleans" => $strictBooleans,
        "carbon" => $carbonRules,
        "rector-preset" => $rectorPresets,
        "phpunit-code-quality" => $phpunitCodeQualityRules,
    ],
    "useRectorCache" => false
];

return $config;
