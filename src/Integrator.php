<?php

declare(strict_types=1);

namespace RectorIntegrationTool;

use Posternak\Commandeer\Builders\Composer;
use Posternak\Commandeer\Builders\Git;
use Posternak\Commandeer\Builders\Rector;
use Posternak\ConsolePrinter\Color;
use Posternak\ConsolePrinter\Printer;
use RectorIntegrationTool\Core\Message;
use RectorIntegrationTool\database\RectorIntegrateDb;
use RectorIntegrationTool\Core\Tester;
use RectorIntegrationTool\Libraries\Projects\PhpProject;

use RuntimeException;
use function Safe\chdir;

final class Integrator {
    private array $config = [];
    private bool $rectorIsSatisfied = true;
    private array $failedRules = [];
    private RectorIntegrateDb $db;
    private Message $message;

    public function __construct(array $config) {
        $this->config = $config;
        $this->db = new RectorIntegrateDb();
        $this->message = new Message();
    }

    public function applyWhatIsProposed(PhpProject $project, string $taskId): void {
        do {
            // Get all refactoring suggestions from Rector
            $fileDiffs = $this->rectorRefactoringSuggestions();

            // Collect all unique rector rules that were trying to change something
            $rulesToApply = [];
            foreach ($fileDiffs as $fileDiff) {
                foreach ($fileDiff['applied_rectors'] as $appliedRector) {
                    if (!in_array($appliedRector, $rulesToApply)) {
                        $rulesToApply[] = $appliedRector;
                    }
                }
            }

            // Apply all unique rules one by one for nice VCS history organization
            foreach ($rulesToApply as $id => $ruleToApply) {
                $this->applyRule($ruleToApply, $id, "mixed");
            }
        } while (count($this->rectorRefactoringSuggestions()) > 0);
    }

    private function rectorRefactoringSuggestions(): array {
        $rectorOutput = Rector::process()->__dry_run()->__clear_cache()->__output_format('json')->run()->getOutput();
        $rectorOutputJson = json_decode(implode("\n", $rectorOutput), true);

        return $rectorOutputJson['file_diffs'] ?? [];
    }

    public function integrate(): void {
        /* @var $project PhpProject */
        $project = $this->config['project'];
        $project->startNewDevelopmentBranch($this->config['vcsBranchName']);
        putenv("PROJECT_NAME=" . basename($this->config['project']->getProjectDir()));

        $this->installPackages();
//           $this->updateConfigPackage(); // for BTA projects only

        $this->addInitialRectorConfigFile();

        do {
            $this->rectorIsSatisfied = true;
            foreach ($this->config["ruleSets"] as $name => $ruleSet) {
                $this->applySetOfRules($ruleSet, $name);
            }
        } while (false);

        // TODO - check this module after all the refactorings
        //$this->skipFailedRulesInRectorConf();
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

    public function applyRule(string $ruleName, int $ruleID, string $ruleSet): void {
        $this->message->horizontalLine();
        $this->message->applyRule($ruleID, $ruleName);

        $attempt = 0;
        while (++$attempt < 5 && !Rector::process()->__only($ruleName)->__clear_cache()->run()->succeeded()) {
            $this->message->rectorFailed();
        }
        if ($attempt === 5) $this->message->rectorFailedCompletely();
        $this->message->done();

        if (Git::hasChanges()) {
            $commitMessage = "[$ruleSet] apply " . $ruleName . " rule.";
            $this->message->testingApp();

            try {
                $testsPassed = Tester::test($this->config['projectType'])->succeeded();
            } catch (RuntimeException $e) {
                $testsPassed = false;
            }
            if ($testsPassed) {
                $this->message->success();

                Git::addEverythingAndCommitWithMessage($commitMessage);
                $this->message->commitedChanges();

                // TODO - refactor and check the database module
//                if (!$this->db->isRuleReviewed($ruleName)) {
//                    $this->db->addNotReviewedRule($ruleName, getenv('PROJECT_NAME'));
//                    $this->message->ruleAddedToNotReviewed();
//                }

                $this->rectorIsSatisfied = false;
            }
            else {
                $this->message->testsFailed();
                Git::reset()->__hard('HEAD');
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

        if (Composer::require(...$packages)->__dev()->run()->succeeded()) $this->message->done();
        else new Printer()->println(" Fail!", [Color::RED]);

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
