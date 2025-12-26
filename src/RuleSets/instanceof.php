<?php

use Rector\CodeQuality\Rector\FuncCall\InlineIsAInstanceOfRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\Instanceof_\Rector\Ternary\FlipNegatedTernaryInstanceofRector;
use Rector\TypeDeclaration\Rector\BooleanAnd\BinaryOpNullableToInstanceofRector;
use Rector\TypeDeclaration\Rector\Empty_\EmptyOnNullableObjectToInstanceOfRector;
use Rector\TypeDeclaration\Rector\While_\WhileNullableToInstanceofRector;

return [
    InlineIsAInstanceOfRector::class,
    FlipTypeControlToUseExclusiveTypeRector::class,
    RemoveDeadInstanceOfRector::class,
    FlipNegatedTernaryInstanceofRector::class,
    BinaryOpNullableToInstanceofRector::class,
    EmptyOnNullableObjectToInstanceOfRector::class,
    WhileNullableToInstanceofRector::class,
];
