<?php

declare(strict_types=1);

$phpUpgradeRules = require __DIR__ . "/RuleSets/phpUpgrade.php";

$config = [
    "projectDir" => "",
    "ruleSets" => [$phpUpgradeRules],
    "useRectorCache" => false
];

return $config;
