<?php

return [
    'Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector',
    'Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector',
    'Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector',
    'Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector',
    'Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector',
    'Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector',
    'Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector',
    'Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector',
];
