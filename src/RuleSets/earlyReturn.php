<?php

use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;

return [
    ChangeNestedForeachIfsToEarlyContinueRector::class,
    ChangeIfElseValueAssignToEarlyReturnRector::class,
    ChangeNestedIfsToEarlyReturnRector::class,
    ChangeOrIfContinueToMultiContinueRector::class,
    RemoveAlwaysElseRector::class,
    PreparedValueToEarlyReturnRector::class,
    ReturnBinaryOrToEarlyReturnRector::class,
    ReturnEarlyIfVariableRector::class,
];
