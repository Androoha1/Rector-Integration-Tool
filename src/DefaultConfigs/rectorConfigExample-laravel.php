<?php

declare(strict_types=1);

use DiviGroup\Configurations\Rector\RectorConfig;

return RectorConfig::configureWithLaravel(__DIR__)
    ->withSkip([])
    ->withCache()
    ->withoutParallel();
