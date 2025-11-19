<?php declare(strict_types=1);

namespace RectorIntegrationTool\Libraries\Files\Json;

use RuntimeException;

class JsonFileManager {
    private static array $fileInstanceMap = [];
    private array $fileDecoded = [];

    protected function __construct(private readonly string $filePath) {
        $this->fileDecoded = Json::decodeFile($this->filePath);
    }

    public static function getInstance(string $filePath): self {
        $filePath = realpath($filePath);

        return self::$fileInstanceMap[$filePath]
            ?? self::$fileInstanceMap[$filePath] = new self($filePath);
    }

    public function getValueByPath(string $path): string|array {
        [$parent, $key] = $this->navigateToPath($path);
        return $parent[$key];
    }

    public function setValueByPath(string $path, string $value, bool $createNonExistingPath = false): void {
        $result = $this->navigateToPath($path, $createNonExistingPath);
        $result[0][$result[1]] = $value;  // Directly use the reference
    }

    public function removeByPath(string $path): void {
        try {
            $result = $this->navigateToPath($path, false);
            unset($result[0][$result[1]]);
        } catch (RuntimeException) {}
    }

    private function navigateToPath(string $path, bool $createNonExistingPath = false): array {
        $keys = explode('.', $path);
        $lastKey = array_pop($keys);

        $current = &$this->fileDecoded;

        foreach ($keys as $key) {
            if (!isset($current[$key])) {
                if (!$createNonExistingPath) {
                    throw new RuntimeException("Path '$path' does not exist");
                }
                $current[$key] = [];
            } elseif (!is_array($current[$key])) {
                throw new RuntimeException("Cannot traverse path '$path': key '$key' is not an array");
            }

            $current = &$current[$key];
        }

        if (!$createNonExistingPath && !isset($current[$lastKey])) {
            throw new RuntimeException("Path '$path' does not exist");
        }

        return [&$current, $lastKey];
    }

    public function save(): void {
        Json::prettyPrintIntoFile($this->fileDecoded, $this->filePath);
    }
}
