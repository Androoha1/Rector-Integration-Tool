<?php

namespace RectorIntegrationTool\Core;

final class Message
{
    public static function applySetOfRules(string $name): void
    {
        echo coloredText("Going to apply rules from the {$name} rule set:\n");
    }

    public static function horizontalLine(): void
    {
        echo "__________________________________________________________\n";
    }

    public static function applyRule(int $ruleID, string $ruleName): void
    {
        echo "$ruleID)" . coloredText($ruleName, "yellow") . " is being applied to your codebase..\n";
    }

    public static function rectorFailed(): void
    {
        echo coloredText(" Rector failed!\n", "red");
    }

    public static function rectorFailedCompletely(): void
    {
        coloredText(" Rector failed completely..! (maybe the rule is ignored)\n", "red");
    }

    public static function done(): void
    {
        echo " Done!\n";
    }

    public static function testingApp(): void
    {
        echo "Testing the app after changes..";
    }

    public static function success(): void
    {
        echo coloredText(" Success!\n", "green");
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
        echo coloredText(" Fail!\n", "red");
        echo "Changes will not be commited because tests didn't pass.\n";
    }

    public static function noChangesMade(): void
    {
        echo "Rector made no changes with this rule.\n";
    }

    public static function installingPackages(): void
    {
        echo coloredText("Installing rector packages with composer.. :\n");
    }

    public static function updateConfPackage(): void
    {
        echo coloredText("Updating the configuration package.. :\n");
    }

    public static function copyConfiguration(): void
    {
        echo coloredText("Copying rector configuration.. : ");
    }

    public static function skipFailedRules(array $failedRules): void
    {
        echo coloredText("Ignoring bad rules in the rector configuration. Here is the list of bad rules:\n");

        foreach ($failedRules as $rule) {
            echo "   -" . basename($rule) . "\n";
        }
    }
}