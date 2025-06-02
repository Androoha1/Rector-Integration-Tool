<?php

declare(strict_types=1);

use DiviGroup\Configurations\Rector\RectorConfig;

return (new RectorConfig)
    ->configureWithLaravel(__DIR__)
    ->withSkip([])
    ->withParallel(maxNumberOfProcess: 10);
