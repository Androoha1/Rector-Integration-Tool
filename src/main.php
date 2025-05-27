<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Androoha\RectorIntegrationTool\Core\Composer;
use Androoha\RectorIntegrationTool\Core\Git;
use Androoha\RectorIntegrationTool\Core\Rector;
use Androoha\RectorIntegrationTool\Core\Artisan;
use Androoha\RectorIntegrationTool\Core\ShellCommand;

$config = require "configuration.php";

final class IntegrateRector {
    private array $config = [];
    private bool $rectorIsSatisfied = true;
    public function __construct() {
        $this->config = require "configuration.php";
    }

    public function integrate(): void {
        chdir($this->config["projectDir"]);
        Git::checkoutNewBranch("ONE-11445-integrate-rector-tool");
        $this->installPackages();
        $this->copyConfiguration();

        do {
            $this->rectorIsSatisfied = true;
            foreach ($this->config["ruleSets"] as $name => $ruleSet) {
                echo coloredText("Going to apply rules from the $name rule set:\n");
                foreach ($ruleSet as $index => $rule) {
                    $this->applyRule($rule, $index, $name);
                }
            }
        } while (!$this->rectorIsSatisfied);
    }

    public function applyRule(string $ruleName, int $ruleID, string $groupName): void {
        echo horizontalLine();

        echo "$ruleID)" . coloredText($ruleName, "yellow") . " is being applied to your codebase..\n";

        $attempt = 0;
        while (++$attempt < 5 && !Rector::process($ruleName,false)->succeeded()) {
            echo coloredText(" Rector failed!\n", "red");
        }
        if ($attempt === 5) echo coloredText(" Rector failed completely..!\n", "red");

        echo " Done!\n";

        if (Git::hasChanges()) {
            $commitMessage = "ONE-11445 [$groupName] apply " . $ruleName . " rule.";
            echo "Testing the app after changes..";
            if (Artisan::test()->succeeded()) {
                echo coloredText(" Success!\n", "green");

                Git::addAll();
                Git::commit($commitMessage);
                echo "Changes are commited!\n";
                $this->rectorIsSatisfied = false;
            }
            else {

                echo coloredText(" Fail!\n", "red");
                echo "Changes will not be commited because tests didn't pass.\n";
                Git::clearAllChanges();
            }
        }
        else echo "Rector made no changes with this rule.\n";

        echo horizontalLine();
    }

    private function installPackages(): void {
        echo coloredText("Installing rector packages with composer.. :");
        if (Composer::require(["rector/rector", "driftingly/rector-laravel"], dev: true)->succeeded()) echo coloredText("Done!\n", "green");
        else echo coloredText(" Fail!\n", "red");

        Git::addAll()->run();
        Git::commit("ONE-11445 add rector and driftingly/rector-laravel as dev dependencies.");
    }

    private function copyConfiguration(): void {
        echo coloredText("Copying rector configuration.. :");
        new ShellCommand("cp " . $this->config["toolDir"] .  "\\src\\rectorConfigExample.php " . $this->config["projectDir"] . "\\rector.php")->run();
        echo coloredText("Done!\n", "green");
    }
}

$integrator = new IntegrateRector();
$integrator->integrate();

