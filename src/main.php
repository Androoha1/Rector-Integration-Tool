<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use RectorIntegrationTool\Core\CliAbstraction\Composer;
use RectorIntegrationTool\Core\CliAbstraction\Git;
use RectorIntegrationTool\Core\CliAbstraction\Rector;
use RectorIntegrationTool\Core\CliAbstraction\ShellCommand;
use RectorIntegrationTool\database\RectorIntegrateDb;
use RectorIntegrationTool\Core\Tester;

$config = require "configuration.php";

final class IntegrateRector {
    private array $config = [];
    private bool $rectorIsSatisfied = true;
    private array $failedRules = [];
    private RectorIntegrateDb $db;

    public function __construct() {
        $this->config = require "configuration.php";
        $this->db = new RectorIntegrateDb();
    }

    public function integrate(): void {
        putenv("PROJECT_NAME=" . basename($this->config["projectDir"]));
        if (is_dir($this->config["projectDir"] . "/web")) $this->config["projectDir"] .= "/web";
        chdir($this->config["projectDir"]);
        Git::checkoutNewBranch($this->config["jiraId"] . "-integrate-rector-tool");

        $this->installPackages();
//        $this->updateConfigPackage();
        $this->copyConfiguration();

        do {
            $this->rectorIsSatisfied = true;
            foreach ($this->config["ruleSets"] as $name => $ruleSet) {
                $this->applySetOfRules($ruleSet, $name);
            }
        } while (!$this->rectorIsSatisfied);

        $this->skipFailedRulesInRectorConf();
    }

    public function applyRule(string $ruleName, int $ruleID, string $groupName): void {
        echo horizontalLine();
        echo "$ruleID)" . coloredText($ruleName, "yellow") . " is being applied to your codebase..\n";

        $attempt = 0;
        while (++$attempt < 5 && !Rector::process(specificRule: $ruleName, clearCache: true)->succeeded()) {
            echo coloredText(" Rector failed!\n", "red");
        }
        if ($attempt === 5) echo coloredText(" Rector failed completely..! (maybe the rule is ignored)\n", "red");
        echo " Done!\n";

        if (Git::hasChanges()) {
            $commitMessage = "ONE-11445 [$groupName] apply " . $ruleName . " rule.";
            echo "Testing the app after changes..";
            if (Tester::test($this->config['projectType'])->succeeded()) {
                echo coloredText(" Success!\n", "green");

                Git::commitAll($commitMessage);
                echo "Changes are commited!\n";

                if (!$this->db->isRuleReviewed($ruleName)) {
                    $this->db->addNotReviewedRule($ruleName, getenv('PROJECT_NAME'));
                    echo "Rule added to not-reviewed list for project: " . getenv('PROJECT_NAME') . PHP_EOL;
                }

                $this->rectorIsSatisfied = false;
            }
            else {
                echo coloredText(" Fail!\n", "red");
                echo "Changes will not be commited because tests didn't pass.\n";
                Git::clearAllChanges();
                if (!in_array($ruleName, $this->failedRules)) $this->failedRules[] = $ruleName;
            }
        }
        else echo "Rector made no changes with this rule.\n";

        echo horizontalLine();
    }

    public function applySetOfRules(array $ruleSet, string $name): void {
        echo coloredText("Going to apply rules from the $name rule set:\n");
        foreach ($ruleSet as $index => $rule) {
            $this->applyRule($rule, $index, $name);
        }
    }

    private function installPackages(): void {
        echo coloredText("Installing rector packages with composer.. :\n");

        $packages = ["rector/rector"];
        if ($this->config["projectDir"] === "laravel") $packages[] = "driftingly/rector-laravel";

        if (Composer::require($packages, dev: true)->succeeded()) echo coloredText("Done!\n", "green");
        else echo coloredText(" Fail!\n", "red");

        Git::commitAll("ONE-11445 add rector and driftingly/rector-laravel as dev dependencies.");
    }

    private function updateConfigPackage(): void {
        echo coloredText("Updating the configuration package.. :\n");

        new ShellCommand('powershell.exe -Command "(Get-Content composer.json) -replace \'\\^v1\\.2\\.0\', \'^v2.0.3\' | Set-Content composer.json"')->run();
        Composer::update();
        new ShellCommand('powershell -Command "(Get-Content phpstan.neon) -replace \'/phpstan\\.neon\', \'/phpstan-laravel.neon\' | Set-Content phpstan.neon"')->run();

        Git::commitAll("ONE-11445 update the configuration package to the newest version.");
    }

    private function copyConfiguration(): void {
        echo coloredText("Copying rector configuration.. : ");

        switch ($this->config['projectType']) {
            case "laravel":
                $fileName = "rectorConfigExample-laravel.php";
                break;
            case "package":
                $fileName = "rectorConfigExample-packages.php";
                break;
            default:
                $fileName = "unknownProjectType.php";
        }

        new ShellCommand('copy "' . $this->config["toolDir"] . '\\src\\DefaultConfigs\\' . $fileName . '" "' . $this->config["projectDir"] . '\\rector.php"')->run()->getOutput();
        echo coloredText("Done!\n", "green");

        Git::commitAll("ONE-11445 add rector base configuration (to be cleaned later).");
    }

    public function skipFailedRulesInRectorConf(): void {
        echo coloredText("Ignoring bad rules in the rector configuration. Here is the list of bad rules:\n");
        foreach ($this->failedRules as $rule) {
            echo "   -" . basename($rule) . "\n";
        }

        $export = var_export($this->failedRules, true);
        $file = $this->config["toolDir"] . '/temp/failedRules-' . getenv('PROJECT_NAME') . ".php";
        file_put_contents($file, "<?php\n\nreturn $export;\n");

        chdir($this->config["toolDir"]);
        Rector::process(clearCache: true, path: "\"". $this->config["projectDir"] . '/rector.php' . "\"");
        Rector::process(clearCache: true, path: "\"". $this->config["projectDir"] . '/rector.php' . "\"");

        chdir($this->config["projectDir"]);
        Git::commitAll("ONE-11445 ignore rules that broke the project.");
    }
}

$integrator = new IntegrateRector();
$integrator->integrate();
