<?php

return [
    'Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector',
//    'Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector', -> ban for BTA
    'Rector\Strict\Rector\If_\BooleanInIfConditionRuleFixerRector',
    'Rector\Strict\Rector\Ternary\BooleanInTernaryOperatorRuleFixerRector',
    'Rector\Strict\Rector\Ternary\DisallowedShortTernaryRuleFixerRector',
];
