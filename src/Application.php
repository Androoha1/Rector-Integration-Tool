<?php

declare(strict_types=1);

namespace RectorIntegrationTool;

use Posternak\Commandeer\Builders\Composer;
use Posternak\Commandeer\Builders\Git;
use Posternak\Commandeer\Builders\Rector;
use Posternak\Commandeer\ShellCommand;
use Posternak\ConsolePrinter\Color;
use Posternak\ConsolePrinter\Printer;
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
    private Message $message;

    public function __construct() {
        $this->config = require "configuration.php";
        $this->db = new RectorIntegrateDb();
        $this->message = new Message();
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
        $this->message->copyConfiguration();
        copy(
            $this->config["toolDir"] . '\\src\\DefaultConfigs\\rectorConfigExample-general-vanillaPHP.php',
            $this->config["project"]->getProjectWebDir() . '\\rector.php'
        );
        $this->message->done();

        Git::addEverythingAndCommitWithMessage("Add rector base configuration.");
    }

    public function applyRule(string $ruleName, int $ruleID, string $groupName): void {
        $this->message->horizontalLine();
        $this->message->applyRule($ruleID, $ruleName);

        $attempt = 0;
        while (++$attempt < 5 && !Rector::process()->__only($ruleName)->__clear_cache()->succeeded()) {
            $this->message->rectorFailed();
        }
        if ($attempt === 5) $this->message->rectorFailedCompletely();
        $this->message->done();

        if (Git::hasChanges()) {
            $commitMessage = "ONE-11445 [$groupName] apply " . $ruleName . " rule.";
            $this->message->testingApp();
            if (Tester::test($this->config['projectType'])->succeeded()) {
                $this->message->success();

                Git::commitAll($commitMessage);
                $this->message->commitedChanges();

                if (!$this->db->isRuleReviewed($ruleName)) {
                    $this->db->addNotReviewedRule($ruleName, getenv('PROJECT_NAME'));
                    $this->message->ruleAddedToNotReviewed();
                }

                $this->rectorIsSatisfied = false;
            }
            else {
                $this->message->testsFailed();
                Git::clearAllChanges();
                if (!in_array($ruleName, $this->failedRules)) $this->failedRules[] = $ruleName;
            }
        }
        else $this->message->noChangesMade();

        $this->message->horizontalLine();
    }

    public function applySetOfRules(array $ruleSet, string $name): void {
        $this->message->applySetOfRules($name);
        foreach ($ruleSet as $index => $rule) {
            $this->applyRule($rule, $index, $name);
        }
    }

    private function installPackages(): void {
        $this->message->installingPackages();

        $packages = ["rector/rector"];
        if ($this->config["projectType"] === "laravel") $packages[] = "driftingly/rector-laravel";

        Composer::require(...$packages)->__dev()->run()->succeeded();

        if (Composer::require(...$packages)->__dev()->run()->succeeded()) Message::done();
        new Printer()->println(" Fail!", [Color::RED]);

        Git::addEverythingAndCommitWithMessage("Install rector packages.");
    }

    private function updateConfigPackage(): void {
        $this->message->updateConfPackage();

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
        $this->message->copyConfiguration();

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
        $this->message->done();

        Git::addEverythingAndCommitWithMessage("ONE-11445 add rector base configuration (to be cleaned later).");
    }

    public function skipFailedRulesInRectorConf(): void {
        $this->message->skipFailedRules($this->failedRules);

        $export = var_export($this->failedRules, true);
        $file = $this->config["toolDir"] . '/temp/failedRules-' . getenv('PROJECT_NAME') . ".php";
        file_put_contents($file, "<?php\n\nreturn $export;\n");

        chdir($this->config["toolDir"]);
        Rector::process("\"". $this->config["projectDir"] . '/rector.php' . "\"")->__clear_cache();

        chdir($this->config["projectDir"]);
        Git::addEverythingAndCommitWithMessage("ONE-11445 ignore rules that broke the project.");
    }
}
