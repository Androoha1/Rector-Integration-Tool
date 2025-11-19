<?php declare(strict_types=1);

namespace Tests\Unit\Libraries\Files\Json\Composer\ComposerJsonFileManager;

use PHPUnit\Framework\Attributes\DataProvider;
use RectorIntegrationTool\Libraries\Files\Json\Composer\ComposerJsonFileManager;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ComposerJsonFileManagerTest extends TestCase {
    private static string $realLifeComposerJsonFile = __DIR__ . '/Mocks/real-life-composer-json-file.json';

    #[Test]
    #[DataProvider('provideForGetsPackageVersionConstraint')]
    public function getsPackageVersionConstraint(string $packageName, string $expectedVersionConstraint): void {
        $composerJsonFileManager = new ComposerJsonFileManager(self::$realLifeComposerJsonFile);
        $this->assertSame($expectedVersionConstraint, $composerJsonFileManager->getPackageVersionConstraint($packageName));
    }

    public static function provideForGetsPackageVersionConstraint(): array {
        return [
            ['divi-group/jobs', '^1.0.0'],
            ['laravel/framework', '^v12.8.1'],
            ['thecodingmachine/safe', '^v3.0.2'],
        ];
    }
}
