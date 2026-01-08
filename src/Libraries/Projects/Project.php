<?php

namespace RectorIntegrationTool\Libraries\Projects;

use Exception;
use Illuminate\Support\Collection;
use Posternak\Commandeer\Builders\Composer;
use Posternak\Commandeer\Builders\Git;

class Project {
    private string $name;
    protected string $projectDir;
    protected string $projectWebDir;
    private Collection $tags;

    public function __construct(string $projectDir, Collection $tags = new Collection(), ?string $name = null) {
        $this->projectDir = $projectDir;
        $this->projectWebDir = $projectDir;
        $this->projectWebDir .= is_dir($projectDir . '/web') ? '/web' : '';
        $this->tags = $tags;
        $this->name = $name ?? basename($projectDir);
    }

    public function getProjectDir(): string {
        return $this->projectDir;
    }

    public function getProjectWebDir(): string
    {
        return $this->projectWebDir;
    }

    public function getProjectName(): string {
        return $this->name;
    }

    public function containsTag(string $tag): bool {
        return $this->tags->contains($tag);
    }

    public function startNewDevelopmentBranch(string $branchName): void {
        chdir($this->projectWebDir);
        if (!Git::isWorkingTreeClean()) {
            throw new Exception("The project has some changes that are not saved!");
        }
        Git::checkout('main');
        Git::pull();
        Composer::install();
        Git::checkoutNewBranch($branchName);
    }
}
