<?php

declare(strict_types=1);

use DiviGroup\Configurations\Rector\RectorConfig;

return RectorConfig::configure(__DIR__)
    ->withSkip([])
    ->withCache(cacheDirectory: 'C:\Users\andrii.posternak\AppData\Local\Temp\rector_cached_files')
    ->withoutParallel();
