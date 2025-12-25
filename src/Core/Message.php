<?php

namespace RectorIntegrationTool\Core;

use Posternak\ConsolePrinter\Color;
use Posternak\ConsolePrinter\Printer;

final class Message
{
    private static Printer $printer;

    public static function applySetOfRules(string $name): void
    {
        self::$printer->println("{Going to apply rules from the {{$name}} rule set:}", [Color::YELLOW, Color::RED]);
    }

    public static function horizontalLine(): void
    {
        echo "__________________________________________________________\n";
    }

    public static function applyRule(int $ruleID, string $ruleName): void
    {
        self::$printer->println("$ruleID){{$ruleName}} is being applied to your codebase..", [Color::YELLOW]);
    }

    public static function rectorFailed(): void
    {
        self::$printer->println("Rector failed!", [Color::RED]);
    }

    public static function rectorFailedCompletely(): void
    {
        self::$printer->println("Rector failed completely..! (maybe the rule is ignored)", [Color::RED]);
    }

    public static function done(): void
    {
        self::$printer->println(" Done!", [Color::GREEN]);
    }

    public static function testingApp(): void
    {
        echo "Testing the app after changes..";
    }

    public static function success(): void
    {
        self::$printer->println("Success!", [Color::GREEN]);
    }

    public static function commitedChanges(): void
    {
        echo "Changes are commited!\n";
    }

    public static function ruleAddedToNotReviewed(): void
    {
        echo "Rule added to not-reviewed list for project: " . getenv('PROJECT_NAME') . PHP_EOL;
    }

    public static function testsFailed(): void
    {
        self::$printer->println(" Fail!", [Color::RED]);
        echo "Changes will not be commited because tests didn't pass.\n";
    }

    public static function noChangesMade(): void
    {
        echo "Rector made no changes with this rule.\n";
    }

    public static function installingPackages(): void
    {
        self::$printer->println("Installing packages...", [Color::SOFT_BLUE]);
    }

    public static function updateConfPackage(): void
    {
        self::$printer->println("Updating the configuration package.. :", [Color::SOFT_BLUE]);
    }

    public static function copyConfiguration(): void
    {
        self::$printer->print("Copying rector configuration.. : ", [Color::SOFT_BLUE]);
    }

    public static function skipFailedRules(array $failedRules): void
    {
        self::$printer->println("Ignoring bad rules in the rector configuration. Here is the list of bad rules:", [Color::SOFT_BLUE]);

        foreach ($failedRules as $rule) {
            echo "   -" . basename($rule) . "\n";
        }
    }
}
