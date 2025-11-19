<?php declare(strict_types=1);

namespace RectorIntegrationTool\Libraries\Projects;

use Illuminate\Support\Collection;
use RectorIntegrationTool\Libraries\Files\Json\Composer\ComposerJsonFileManager;
use RectorIntegrationTool\Libraries\Files\Json\Composer\ComposerLockFileManager;

class PhpProject extends Project {
    public readonly ComposerJsonFileManager $composerJsonFileManager;
    public readonly ComposerLockFileManager $composerLockFileManager;

    public function __construct(string $projectDir, Collection $tags) {
        parent::__construct($projectDir, $tags);
        $this->composerJsonFileManager = new ComposerJsonFileManager($this->projectWebDir . '/composer.json');
        $this->composerLockFileManager = new ComposerLockFileManager($this->projectWebDir . '/composer.lock');
    }
}
