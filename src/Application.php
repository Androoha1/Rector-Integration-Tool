<?php

declare(strict_types=1);

namespace RectorIntegrationTool;

use Posternak\Commandeer\Builders\Composer;
use Posternak\Commandeer\Builders\Git;
use Posternak\Commandeer\Builders\Rector;
use Posternak\Commandeer\ShellCommand;
use RectorIntegrationTool\Core\Message;
use RectorIntegrationTool\database\RectorIntegrateDb;
use RectorIntegrationTool\Core\Tester;

use RectorIntegrationTool\Libraries\Projects\PhpProject;
use function Safe\chdir;

final class Application {
    private array $config = [];
    private bool $rectorIsSatisfied = true;
    private array $failedRules = [];
    private RectorIntegrateDb $db;

    public function __construct() {
        $this->config = require "configuration.php";
        $this->db = new RectorIntegrateDb();
    }

    public function integrate(): void {
        if ($notDone = true) {
            /* @var $project PhpProject */
            $project = $this->config['project'];
            $project->startNewDevelopmentBranch($this->config['vcsBranchName']);
            putenv("PROJECT_NAME=" . basename($this->config['project']->getProjectDir()));

            $this->installPackages();

            $this->addInitialRectorConfigFile();
        }

        $dd = 5;



//        $this->installPackages();
//        $this->updateConfigPackage();
//        $this->copyConfiguration();
//
//        do {
//            $this->rectorIsSatisfied = true;
//            foreach ($this->config["ruleSets"] as $name => $ruleSet) {
//                $this->applySetOfRules($ruleSet, $name);
//            }
//        } while (false);
//
//        $this->skipFailedRulesInRectorConf();
    }

    private function addInitialRectorConfigFile(): void {
        Message::copyConfiguration();
        copy(
            $this->config["toolDir"] . '\\src\\DefaultConfigs\\rectorConfigExample-general-vanillaPHP.php',
            $this->config["project"]->getProjectWebDir() . '\\rector.php'
        );
        Message::done();

        Git::addEverythingAndCommitWithMessage("Add rector base configuration.");
    }

    public function applyRule(string $ruleName, int $ruleID, string $groupName): void {
        Message::horizontalLine();
        Message::applyRule($ruleID, $ruleName);

        $attempt = 0;
        while (++$attempt < 5 && !Rector::process()->__only($ruleName)->__clear_cache()->succeeded()) {
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
        if ($this->config["projectType"] === "laravel") $packages[] = "driftingly/rector-laravel";

        Composer::require(...$packages)->__dev()->run()->succeeded();

        if (Composer::require(...$packages)->__dev()->run()->succeeded()) echo coloredText("Done!\n", "green");
        else echo coloredText(" Fail!\n", "red");

        Git::addEverythingAndCommitWithMessage("Install rector packages.");
    }

    private function updateConfigPackage(): void {
        Message::updateConfPackage();

        // TODO: don't use this legacy logic function
        updatePackageVersionConstraint(
            $this->config["projectDir"] . '/composer.json',
            "divi-group/configurations",
            "dev-ONE-12064-custom-rector-rules",
            true
        );
        Composer::update();

        Git::addEverythingAndCommitWithMessage("ONE-11445 update the configuration package.");
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

        new ShellCommand('copy "' . $this->config["toolDir"] . '\\src\\DefaultConfigs\\' . $fileName . '" "' . $this->config["project"]->getProjectWebDir() . '\\rector.php"')->run();
        Message::done();

        Git::addEverythingAndCommitWithMessage("ONE-11445 add rector base configuration (to be cleaned later).");
    }

    public function skipFailedRulesInRectorConf(): void {
        Message::skipFailedRules($this->failedRules);

        $export = var_export($this->failedRules, true);
        $file = $this->config["toolDir"] . '/temp/failedRules-' . getenv('PROJECT_NAME') . ".php";
        file_put_contents($file, "<?php\n\nreturn $export;\n");

        chdir($this->config["toolDir"]);
        Rector::process("\"". $this->config["projectDir"] . '/rector.php' . "\"")->__clear_cache();

        chdir($this->config["projectDir"]);
        Git::addEverythingAndCommitWithMessage("ONE-11445 ignore rules that broke the project.");
    }
}
