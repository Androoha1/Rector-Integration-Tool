<?php

namespace RectorIntegrationTool\Core;

use Posternak\ConsolePrinter\Color;
use Posternak\ConsolePrinter\Printer;

final class Message
{
    private Printer $printer;

    public function __construct(?Printer $printer = null)
    {
        $this->printer = $printer ?? new Printer();
    }

    public function startingNewDevelopmentBranch(): void {
        $this->printer->println("Starting a new development branch for the project under integration..", [Color::SOFT_BLUE]);
    }

    public function applySetOfRules(string $name): void
    {
        $this->printer->println("{Going to apply rules from the {{$name}} rule set:}", [Color::YELLOW, Color::RED]);
    }

    public function horizontalLine(): void
    {
        echo "__________________________________________________________\n";
    }

    public function applyRule(int $ruleID, string $ruleName): void
    {
        $this->printer->println("$ruleID){{$ruleName}} is being applied to your codebase..", [Color::YELLOW]);
    }

    public function rectorFailed(): void
    {
        $this->printer->println("Rector failed!", [Color::RED]);
    }

    public function rectorFailedCompletely(): void
    {
        $this->printer->println("Rector failed completely..! (maybe the rule is ignored)", [Color::RED]);
    }

    public function done(): void
    {
        $this->printer->println(" Done!", [Color::GREEN]);
    }

    public function testingApp(): void
    {
        echo "Testing the app after changes..";
    }

    public function success(): void
    {
        $this->printer->println("Success!", [Color::GREEN]);
    }

    public function commitedChanges(): void
    {
        echo "Changes are commited!\n";
    }

    public function ruleAddedToNotReviewed(): void
    {
        echo "Rule added to not-reviewed list for project: " . getenv('PROJECT_NAME') . PHP_EOL;
    }

    public function testsFailed(): void
    {
        $this->printer->println(" Fail!", [Color::RED]);
        echo "Changes will not be commited because tests didn't pass.\n";
    }

    public function noChangesMade(): void
    {
        echo "Rector made no changes with this rule.\n";
    }

    public function installingPackages(): void
    {
        $this->printer->println("Installing packages...", [Color::SOFT_BLUE]);
    }

    public function updateConfPackage(): void
    {
        $this->printer->println("Updating the configuration package.. :", [Color::SOFT_BLUE]);
    }

    public function copyConfiguration(): void
    {
        $this->printer->print("Copying rector configuration.. : ", [Color::SOFT_BLUE]);
    }

    public function skipFailedRules(array $failedRules): void
    {
        $this->printer->println("Ignoring bad rules in the rector configuration. Here is the list of bad rules:", [Color::SOFT_BLUE]);

        foreach ($failedRules as $rule) {
            echo "   -" . basename($rule) . "\n";
        }
    }
}
