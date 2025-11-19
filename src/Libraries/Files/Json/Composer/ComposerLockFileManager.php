<?php declare(strict_types=1);

namespace RectorIntegrationTool\Libraries\Files\Json\Composer;

use RectorIntegrationTool\Libraries\Files\Json\JsonFileManager;

class ComposerLockFileManager {
    private JsonFileManager $jsonFileManager;

    public function __construct(string $composerLockPath) {
        $this->jsonFileManager = JsonFileManager::getInstance($composerLockPath);
    }

    public function getInstalledPackageVersion(string $packageName): ?string {
        $packageInfo = $this->getPackageInfo($packageName);
        return $packageInfo['version'] ?? null;
    }

    public function getPackageInfo(string $packageName): ?array {
        $allPackages = array_merge(
            $this->jsonFileManager->getValueByPath('packages'),
            $this->jsonFileManager->getValueByPath('packages-dev') ?? []
        );

        foreach ($allPackages as $package) {
            if ($package['name'] === $packageName) {
                return $package;
            }
        }

        return null;
    }
}