<?php

use Rector\Carbon\Rector\FuncCall\DateFuncCallToCarbonRector;
use Rector\Carbon\Rector\FuncCall\TimeFuncCallToCarbonRector;
use Rector\Carbon\Rector\MethodCall\DateTimeMethodCallToCarbonRector;
use Rector\Carbon\Rector\New_\DateTimeInstanceToCarbonRector;

return [
    DateFuncCallToCarbonRector::class,
    TimeFuncCallToCarbonRector::class,
    DateTimeMethodCallToCarbonRector::class,
    DateTimeInstanceToCarbonRector::class,
];
