<?php

declare(strict_types=1);

use DiviGroup\Configurations\Rector\RectorConfig;

return RectorConfig::configure(__DIR__)
    ->withSkip([])
    ->withoutParallel();
