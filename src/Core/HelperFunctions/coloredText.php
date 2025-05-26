<?php

declare(strict_types=1);

function coloredText(string $text, string $color = 'blue'): string {
    $colors = [
        'red' => "\033[31m",
        'green' => "\033[32m",
        'blue' => "\033[34m",
        'yellow' => "\033[33m",
    ];

    return $colors[$color] . $text . "\033[0m";
}
