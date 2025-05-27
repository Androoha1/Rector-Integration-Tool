<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Androoha\RectorIntegrationTool\Core\Git;
use Androoha\RectorIntegrationTool\Core\Rector;
use Androoha\RectorIntegrationTool\Core\Artisan;

$config = require "configuration.php";

final class IntegrateRector {
    private array $config = [];
    private bool $rectorIsSatisfied = true;
    public function __construct() {
        $this->config = require "configuration.php";
        chdir($this->config["projectDir"]);
    }

    public function integrate(): void {
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

        $rectorCall = new Rector($this->config["useRectorCache"])->process()->only($ruleName);
        while (!$rectorCall->run()->succeeded()) {
            echo coloredText(" Rector failed!\n", "red");
        }

        echo " Done!\n";

        if (Git::hasChanges()) {
            $commitMessage = "ONE-11445 [$groupName] apply " . $ruleName . " rule.";
            echo "Testing the app after changes..";
            if (new Artisan()->test()->run()->succeeded()) {
                echo coloredText(" Success!\n", "green");

                new Git()->addAll()->run();
                new Git()->commit($commitMessage)->run();
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
}

$integrator = new IntegrateRector();
$integrator->integrate();

