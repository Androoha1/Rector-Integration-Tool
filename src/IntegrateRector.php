<?php

declare(strict_types=1);

namespace RectorIntegrationTool;

use Posternak\Commandeer\Facades\Git;
use RectorIntegrationTool\Core\CliAbstraction\Composer;
use RectorIntegrationTool\Core\CliAbstraction\Rector;
use RectorIntegrationTool\Core\CliAbstraction\ShellCommand;
use RectorIntegrationTool\Core\Message;
use RectorIntegrationTool\database\RectorIntegrateDb;
use RectorIntegrationTool\Core\Tester;

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
        putenv("PROJECT_NAME=" . (($projectName = basename($this->config["projectDir"])) === "web") ? basename($projectName) : $projectName);
        if (is_dir($this->config["projectDir"] . "/web")) $this->config["projectDir"] .= "/web";
        chdir($this->config["projectDir"]);
        Git::checkoutNewBranch($this->config["jiraId"] . "-integrate-rector-tool");

        $this->installPackages();
        $this->updateConfigPackage();
        $this->copyConfiguration();

        do {
            $this->rectorIsSatisfied = true;
            foreach ($this->config["ruleSets"] as $name => $ruleSet) {
                $this->applySetOfRules($ruleSet, $name);
            }
        } while (false);

        $this->skipFailedRulesInRectorConf();
    }

    public function applyRule(string $ruleName, int $ruleID, string $groupName): void {
        Message::horizontalLine();
        Message::applyRule($ruleID, $ruleName);

        $attempt = 0;
        while (++$attempt < 5 && !Rector::process(specificRule: $ruleName, clearCache: true)->succeeded()) {
            Message::rectorFailed();
        }
        if ($attempt === 5) Message::rectorFailedCompletely();
        Message::done();

        if (Git::hasChanges()) {
            $commitMessage = "ONE-11445 [$groupName] apply " . $ruleName . " rule.";
            Message::testingApp();
            if (Tester::test($this->config['projectType'])->succeeded()) {
                Message::success();

                Git::commitAll($commitMessage);
                Message::commitedChanges();

                if (!$this->db->isRuleReviewed($ruleName)) {
                    $this->db->addNotReviewedRule($ruleName, getenv('PROJECT_NAME'));
                    Message::ruleAddedToNotReviewed();
                }

                $this->rectorIsSatisfied = false;
            }
            else {
                Message::testsFailed();
                Git::clearAllChanges();
                if (!in_array($ruleName, $this->failedRules)) $this->failedRules[] = $ruleName;
            }
        }
        else Message::noChangesMade();

        Message::horizontalLine();
    }

    public function applySetOfRules(array $ruleSet, string $name): void {
        Message::applySetOfRules($name);
        foreach ($ruleSet as $index => $rule) {
            $this->applyRule($rule, $index, $name);
        }
    }

    private function installPackages(): void {
        Message::installingPackages();

        $packages = ["rector/rector"];
        if ($this->config["projectDir"] === "laravel") $packages[] = "driftingly/rector-laravel";

        if (Composer::require($packages, dev: true)->succeeded()) echo coloredText("Done!\n", "green");
        else echo coloredText(" Fail!\n", "red");

        Git::commitAll("ONE-11445 add rector dependencies.");
    }

    private function updateConfigPackage(): void {
        Message::updateConfPackage();

        Composer::updatePackageVersionConstraint(
            $this->config["projectDir"] . '/composer.json',
            "divi-group/configurations",
            "dev-ONE-12064-custom-rector-rules",
            true
        );
        Composer::update();

        Git::commitAll("ONE-11445 update the configuration package.");
    }

    private function copyConfiguration(): void {
        Message::copyConfiguration();

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
        Message::done();

        Git::commitAll("ONE-11445 add rector base configuration (to be cleaned later).");
    }

    public function skipFailedRulesInRectorConf(): void {
        Message::skipFailedRules($this->failedRules);

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
