<?php

return [
    'Rector\CodeQuality\Rector\FuncCall\InlineIsAInstanceOfRector',
//    'Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector', -> ban for BTA
    'Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector',
    'Rector\Instanceof_\Rector\Ternary\FlipNegatedTernaryInstanceofRector',
    'Rector\TypeDeclaration\Rector\BooleanAnd\BinaryOpNullableToInstanceofRector',
    'Rector\TypeDeclaration\Rector\Empty_\EmptyOnNullableObjectToInstanceOfRector',
    'Rector\TypeDeclaration\Rector\While_\WhileNullableToInstanceofRector',
];
