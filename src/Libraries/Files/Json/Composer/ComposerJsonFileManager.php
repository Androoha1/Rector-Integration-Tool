<?php declare(strict_types=1);

namespace RectorIntegrationTool\Libraries\Files\Json\Composer;

use RectorIntegrationTool\Libraries\Files\Json\JsonFileManager;
use RuntimeException;

class ComposerJsonFileManager extends JsonFileManager {
    public function __construct(string $filePath) {
        parent::__construct($filePath);
    }

    public function getPackageVersionConstraint(string $packageName): ?string {
        $packages = array_merge(
            $this->getValueByPath('require'),
            $this->getValueByPath('require-dev')
        );

        return $packages[$packageName] ?? null;
    }

    public function setPackageVersionConstraint(string $packageName, string $versionConstraint): self {
        $packages = $this->getValueByPath('require');
        $devPackages = $this->getValueByPath('require-dev');

        if (isset($packages[$packageName])) {
            $this->setValueByPath('require.' . $packageName, $versionConstraint);
        }
        elseif (isset($devPackages[$packageName])) {
            $this->setValueByPath('require-dev.' . $packageName, $versionConstraint);
        }
        else {
            throw new RuntimeException("Package '$packageName' not found in 'require' or 'require-dev'");
        }

        return $this;
    }
}
