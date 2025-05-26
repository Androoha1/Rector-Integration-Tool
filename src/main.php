<?php

declare(strict_types=1);

$config = require "configuration.php";

final class IntegrateRector {
    private array $config = [];
    /** @var string[] */
    private array $allRules;
    public function __construct() {
        $this->config = require "configuration.php";
        chdir($this->config["projectDir"]);
    }

    public function integrate(): void {
        foreach ($this->config["ruleSets"] as $name => $ruleSet) {
            echo "Going to apply rules from the " . coloredEcho($ruleSet["name"]) . " rule set:\n";
            foreach ($ruleSet as $index => $rule) {
                $this->applyRule($rule, $index);
            }
        }
    }

    public function applyRule(string $ruleName, int $ruleID): void {
        echo "__________________________________________________________\n";

        echo "$ruleID)\033[33m$ruleName\033[0m is being applied to your codebase..\n";
        $rectorCall = new Rector($this->config["useRectorCache"])->process()->only($ruleName)->run();

        $output = $rectorCall->getOutput();
        $firstLines = array_slice($output, 0, 5);
        $outputPreview = implode("\n", $firstLines);
        if (count($output) > 5) {
            $outputPreview .= "\n... (" . (count($output) - 5) . " more lines)";
        }
        assert(
            $rectorCall->succeeded() === true,
            "\nHere is the preview of the failed command output: $outputPreview"
        );
        echo " Done!\n";

        if (Git::hasChanges()) {
            $commitMessage = "ONE-11445 apply " . $ruleName . " rule.";
            echo "Testing the app after changes..";
            if (new Artisan()->test()->run()->succeeded()) {
                echo " \033[32mSuccess!\033[0m\n";

                new Git()->addAll()->run();
                new Git()->commit($commitMessage)->run();
                echo "Changes are commited!\n";
            }
            else {
                echo " \033[31mFail!\033[0m\n";
                echo "Changes will not be commited because tests didn't pass.\n";
                Git::clearAllChanges();
            }
        }
        else echo "Rector made no changes with this rule.\n";

        echo "__________________________________________________________\n";
    }
}

$integrator = new IntegrateRector();
$integrator->integrate();

