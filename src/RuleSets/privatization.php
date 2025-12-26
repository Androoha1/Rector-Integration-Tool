<?php

use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;

return [
    PrivatizeFinalClassMethodRector::class,
    PrivatizeLocalGetterToPropertyRector::class,
    PrivatizeFinalClassPropertyRector::class,
];
