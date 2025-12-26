<?php

use Rector\CodeQuality\Rector\Assign\CombinedAssignRector;
use Rector\CodeQuality\Rector\BooleanAnd\RemoveUselessIsObjectCheckRector;
use Rector\CodeQuality\Rector\BooleanAnd\RepeatedAndNotEqualToNotInArrayRector;
use Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use Rector\CodeQuality\Rector\BooleanNot\ReplaceConstantBooleanNotRector;
use Rector\CodeQuality\Rector\BooleanNot\ReplaceMultipleBooleanNotRector;
use Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector;
use Rector\CodeQuality\Rector\BooleanOr\RepeatedOrEqualToInArrayRector;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodeQuality\Rector\ClassConstFetch\VariableConstFetchToClassConstFetchRector;
use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\CodeQuality\Rector\ClassMethod\InlineArrayReturnAssignRector;
use Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector;
use Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\Class_\ConvertStaticToSelfRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Class_\RemoveReadonlyPropertyVisibilityOnReadonlyClassRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector;
use Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use Rector\CodeQuality\Rector\Expression\TernaryFalseExpressionToIfRector;
use Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector;
use Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector;
use Rector\CodeQuality\Rector\FuncCall\CallUserFuncWithArrowFunctionToInlineRector;
use Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\FuncCall\InlineIsAInstanceOfRector;
use Rector\CodeQuality\Rector\FuncCall\IsAWithStringWithThirdArgumentRector;
use Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector;
use Rector\CodeQuality\Rector\FuncCall\SetTypeToCastRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyFuncGetArgsCountRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector;
use Rector\CodeQuality\Rector\FuncCall\SingleInArrayToCompareRector;
use Rector\CodeQuality\Rector\FuncCall\SortNamedParamRector;
use Rector\CodeQuality\Rector\FuncCall\UnwrapSprintfOneArgumentRector;
use Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector;
use Rector\CodeQuality\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodeQuality\Rector\If_\CompleteMissingIfElseBracketRector;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNullableReturnRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector;
use Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector;
use Rector\CodeQuality\Rector\NullsafeMethodCall\CleanupUnneededNullsafeOperatorRector;
use Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector;
use Rector\CodeQuality\Rector\Switch_\SwitchTrueToIfRector;
use Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector;
use Rector\CodeQuality\Rector\Ternary\NumberCompareToMaxFuncCallRector;
use Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodeQuality\Rector\Ternary\TernaryEmptyArrayArrayDimFetchToCoalesceRector;
use Rector\CodeQuality\Rector\Ternary\TernaryImplodeToImplodeRector;
use Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;

return [
    CombinedAssignRector::class,
    RemoveUselessIsObjectCheckRector::class,
    RepeatedAndNotEqualToNotInArrayRector::class,
    SimplifyEmptyArrayCheckRector::class,
    ReplaceConstantBooleanNotRector::class,
    ReplaceMultipleBooleanNotRector::class,
    SimplifyDeMorganBinaryRector::class,
    RepeatedOrEqualToInArrayRector::class,
    ThrowWithPreviousExceptionRector::class,
    VariableConstFetchToClassConstFetchRector::class,
    ExplicitReturnNullRector::class,
    InlineArrayReturnAssignRector::class,
    LocallyCalledStaticMethodToNonStaticRector::class,
    OptionalParametersAfterRequiredRector::class,
    CompleteDynamicPropertiesRector::class,
    ConvertStaticToSelfRector::class,
    InlineConstructorDefaultToPropertyRector::class,
    RemoveReadonlyPropertyVisibilityOnReadonlyClassRector::class,
    JoinStringConcatRector::class,
    SimplifyEmptyCheckOnEmptyArrayRector::class,
    UseIdenticalOverEqualWithSameTypeRector::class,
    InlineIfToExplicitIfRector::class,
    TernaryFalseExpressionToIfRector::class,
    ForRepeatedCountToOwnVariableRector::class,
    ForeachItemsAssignToEmptyArrayToAssignRector::class,
    ForeachToInArrayRector::class,
    SimplifyForeachToCoalescingRector::class,
    UnusedForeachValueToArrayKeysRector::class,
    ArrayMergeOfNonArraysToSimpleArrayRector::class,
    CallUserFuncWithArrowFunctionToInlineRector::class,
    ChangeArrayPushToArrayAssignRector::class,
    CompactToVariablesRector::class,
    InlineIsAInstanceOfRector::class,
    IsAWithStringWithThirdArgumentRector::class,
    RemoveSoleValueSprintfRector::class,
    SetTypeToCastRector::class,
    SimplifyFuncGetArgsCountRector::class,
    SimplifyInArrayValuesRector::class,
    SimplifyRegexPatternRector::class,
    SimplifyStrposLowerRector::class,
    SingleInArrayToCompareRector::class,
    SortNamedParamRector::class,
    UnwrapSprintfOneArgumentRector::class,
    BooleanNotIdenticalToNotIdenticalRector::class,
    FlipTypeControlToUseExclusiveTypeRector::class,
    SimplifyArraySearchRector::class,
    SimplifyBoolIdenticalTrueRector::class,
    SimplifyConditionsRector::class,
    StrlenZeroToIdenticalEmptyStringRector::class,
    CombineIfRector::class,
    CompleteMissingIfElseBracketRector::class,
    ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class,
    ExplicitBoolCompareRector::class,
    ShortenElseIfRector::class,
    SimplifyIfElseToTernaryRector::class,
    SimplifyIfNotNullReturnRector::class,
    SimplifyIfNullableReturnRector::class,
    SimplifyIfReturnBoolRector::class,
    AbsolutizeRequireAndIncludePathRector::class,
    IssetOnPropertyObjectToPropertyExistsRector::class,
    AndAssignsToSeparateLinesRector::class,
    LogicalToBooleanRector::class,
    NewStaticToNewSelfRector::class,
    CommonNotEqualRector::class,
    CleanupUnneededNullsafeOperatorRector::class,
    SingularSwitchToIfRector::class,
    SwitchTrueToIfRector::class,
    ArrayKeyExistsTernaryThenValueToCoalescingRector::class,
    NumberCompareToMaxFuncCallRector::class,
    SimplifyTautologyTernaryRector::class,
    SwitchNegatedTernaryRector::class,
    TernaryEmptyArrayArrayDimFetchToCoalesceRector::class,
    TernaryImplodeToImplodeRector::class,
    UnnecessaryTernaryExpressionRector::class,
    VarToPublicPropertyRector::class,
    RemoveExtraParametersRector::class,
    RenameFunctionRector::class,
    DisallowedEmptyRuleFixerRector::class,
];
