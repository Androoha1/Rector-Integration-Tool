<?php declare(strict_types=1);

function updatePackageVersionConstraint(string $composerFilePath, string $packageName, string $newVersionConstraint, bool $dev = false): void {
    $composerJsonFileContent = json_decode(file_get_contents($composerFilePath));
    $requireSection = $dev ? "require-dev" : "require";

    $composerJsonFileContent[$requireSection][$packageName] = $newVersionConstraint;

    $updatedContent = json_encode($composerJsonFileContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($composerFilePath, $updatedContent);
}
