<?php

use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector;
use Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\Block\ReplaceBlockToItsStmtsRector;
use Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector;
use Rector\DeadCode\Rector\ClassLike\RemoveTypedPropertyNonMockDocblockRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveArgumentFromDefaultParentCallRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveNullTagValueNodeRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessAssignFromPropertyPromotionRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnExprInConstructRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Closure\RemoveUnusedClosureVariableUseRector;
use Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector;
use Rector\DeadCode\Rector\ConstFetch\RemovePhpVersionIdCheckRector;
use Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector;
use Rector\DeadCode\Rector\For_\RemoveDeadContinueRector;
use Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector;
use Rector\DeadCode\Rector\For_\RemoveDeadLoopRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\FuncCall\RemoveFilterVarOnExactTypeRector;
use Rector\DeadCode\Rector\FunctionLike\NarrowWideUnionReturnTypeRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\DeadCode\Rector\If_\ReduceAlwaysFalseIfOrRector;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\DeadCode\Rector\If_\RemoveTypedPropertyDeadInstanceOfRector;
use Rector\DeadCode\Rector\If_\RemoveUnusedNonEmptyArrayBeforeForeachRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector;
use Rector\DeadCode\Rector\MethodCall\RemoveNullArgOnNullDefaultParamRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\Property\RemoveUselessReadOnlyTagRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\DeadCode\Rector\Stmt\RemoveConditionExactReturnRector;
use Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadCatchRector;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector;

return [
    SimplifyUselessVariableRector::class,
    RemoveDuplicatedArrayKeyRector::class,
    RemoveDoubleAssignRector::class,
    RemoveUnusedVariableAssignRector::class,
    ReplaceBlockToItsStmtsRector::class,
    RemoveAndTrueRector::class,
    RecastingRemovalRector::class,
    RemoveUnusedPrivateClassConstantRector::class,
    RemoveTypedPropertyNonMockDocblockRector::class,
    RemoveArgumentFromDefaultParentCallRector::class,
    RemoveEmptyClassMethodRector::class,
    RemoveNullTagValueNodeRector::class,
    RemoveUnusedConstructorParamRector::class,
    RemoveUnusedPrivateMethodParameterRector::class,
    RemoveUnusedPrivateMethodRector::class,
    RemoveUnusedPromotedPropertyRector::class,
    RemoveUnusedPublicMethodParameterRector::class,
    RemoveUselessAssignFromPropertyPromotionRector::class,
    RemoveUselessParamTagRector::class,
    RemoveUselessReturnExprInConstructRector::class,
    RemoveUselessReturnTagRector::class,
    RemoveUnusedClosureVariableUseRector::class,
    RemoveConcatAutocastRector::class,
    RemovePhpVersionIdCheckRector::class,
    RemoveDeadStmtRector::class,
    SimplifyMirrorAssignRector::class,
    RemoveDeadContinueRector::class,
    RemoveDeadIfForeachForRector::class,
    RemoveDeadLoopRector::class,
    RemoveUnusedForeachKeyRector::class,
    RemoveFilterVarOnExactTypeRector::class,
    NarrowWideUnionReturnTypeRector::class,
    RemoveDeadReturnRector::class,
    ReduceAlwaysFalseIfOrRector::class,
    RemoveAlwaysTrueIfConditionRector::class,
    RemoveDeadInstanceOfRector::class,
    RemoveTypedPropertyDeadInstanceOfRector::class,
    RemoveUnusedNonEmptyArrayBeforeForeachRector::class,
    SimplifyIfElseWithSameContentRector::class,
    UnwrapFutureCompatibleIfPhpVersionRector::class,
    RemoveNullArgOnNullDefaultParamRector::class,
    RemoveNonExistingVarAnnotationRector::class,
    RemoveDeadZeroAndOneOperationRector::class,
    RemoveNullPropertyInitializationRector::class,
    RemoveUnusedPrivatePropertyRector::class,
    RemoveUselessReadOnlyTagRector::class,
    RemoveUselessVarTagRector::class,
    RemoveDeadConditionAboveReturnRector::class,
    RemoveParentCallWithoutParentRector::class,
    RemoveConditionExactReturnRector::class,
    RemoveUnreachableStatementRector::class,
    RemoveDuplicatedCaseInSwitchRector::class,
    TernaryToBooleanOrFalseToBooleanAndRector::class,
    RemoveDeadCatchRector::class,
    RemoveDeadTryCatchRector::class,
];
