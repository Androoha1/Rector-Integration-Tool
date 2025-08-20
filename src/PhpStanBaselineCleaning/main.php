<?php

$isLogging = true;
$projectWebDir = "C:\Users\andrii.posternak\Desktop\BTA_projects\Mobile-App\\rest-api\web";
chdir($projectWebDir);

function escapeForNeon(string $text): string {
    return str_replace("'", "''", $text);
}

function escapeForNeonRegex(string $text): string {
    return preg_quote(escapeForNeon($text), "/");
}

$stanJsonOutput = shell_exec("vendor\\bin\\phpstan.bat analyse --error-format=json --no-progress");
$phpstanResults = json_decode($stanJsonOutput, true);

//retrieve data about ignore.unmatched errors and transform it to the format of the baseline file
$unmatchedPatterns = [];
foreach ($phpstanResults['files'] as $filePath => $fileData) {
    foreach ($fileData['messages'] as $message) {
        if ($message['identifier'] === 'ignore.unmatched') {
            if (preg_match('/Ignored error pattern #(.+?)# \((.+?)\) in path (.+?) was not matched in reported errors./', $message['message'], $matches)) {
                $fullPath = $matches[3];
                $relativePath = str_replace($projectWebDir . '\\', '', $fullPath);
                $relativePath = str_replace('\\', '/', $relativePath); //to match the baseline file format

                $unmatchedPatterns[] = [
                    'pattern' => $matches[1],
                    'identifier' => $matches[2],
                    'path' => $relativePath
                ];
            }
        }
    }
}

if (count($unmatchedPatterns) === 0) {
    if ($isLogging) echo "No unmatched patterns found. Baseline is already clean!\n";
    exit(0);
}
else {
    if ($isLogging) echo "Found " . count($unmatchedPatterns) . " unmatched patterns to remove\n";

    $baselineFile = $projectWebDir . DIRECTORY_SEPARATOR . 'phpstan-baseline.neon';
    $baselineContent = file_get_contents($baselineFile);
    $originalSize = strlen($baselineContent);
    $removedCount = 0;
    $updatedContent = $baselineContent;

    foreach ($unmatchedPatterns as $unmatched) {
        if ($isLogging) echo "Removing: {$unmatched['path']} - {$unmatched['identifier']}\n";

        $escapedPattern = escapeForNeonRegex($unmatched['pattern']);
        $escapedIdentifier = preg_quote($unmatched['identifier'], '/');
        $entryRegex = '/-[^-]*message:[^#]*#' . $escapedPattern . '#[^-]*identifier:\s*' . $escapedIdentifier . '[^-]*?(?=-|\z)/s'; //flexible regex just in case

        if (preg_match($entryRegex, $updatedContent, $match)) {
            if ($isLogging) echo "  Found match: " . trim($match[0]) . "\n";
            $updatedContent = preg_replace($entryRegex, '', $updatedContent, 1);
            $removedCount++;
        } elseif ($isLogging) {
            echo "  Warning: Could not find exact match for this pattern in baseline\n";
        }
    }

    //update the baseline file
    if ($removedCount > 0) {
        file_put_contents($baselineFile, $updatedContent);
        $newSize = strlen($updatedContent);
        if ($isLogging) {
            echo "\n✓ Successfully cleaned baseline file!\n";
            echo "Removed: $removedCount entries\n";
            echo "Size reduced: " . ($originalSize - $newSize) . " bytes\n";
        }
    } elseif ($isLogging) {
        echo "\nNo entries were removed from baseline\n";
    }

    echo "\nDone!\n";
}
