<?php

use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedClassConstantsRector;
use Rector\CodingStyle\Rector\ClassMethod\BinaryOpStandaloneAssignsToDirectRector;
use Rector\CodingStyle\Rector\ClassMethod\FuncGetArgsToVariadicParamRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncToMethodCallRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\CodingStyle\Rector\FuncCall\StrictArraySearchRector;
use Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\Property\SplitGroupedPropertiesRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\CodingStyle\Rector\Stmt\RemoveUselessAliasInUseStatementRector;
use Rector\CodingStyle\Rector\String_\SimplifyQuoteEscapeRector;
use Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector;
use Rector\Visibility\Rector\ClassMethod\ExplicitPublicClassMethodRector;

return [
    SplitDoubleAssignRector::class,
    CatchExceptionNameMatchingTypeRector::class,
    RemoveFinalFromConstRector::class,
    SplitGroupedClassConstantsRector::class,
    BinaryOpStandaloneAssignsToDirectRector::class,
    FuncGetArgsToVariadicParamRector::class,
    MakeInheritedMethodVisibilitySameAsParentRector::class,
    NewlineBeforeNewAssignSetRector::class,
    EncapsedStringsToSprintfRector::class,
    WrapEncapsedVariableInCurlyBracesRector::class,
    CallUserFuncArrayToVariadicRector::class,
    CallUserFuncToMethodCallRector::class,
    ConsistentImplodeRector::class,
    CountArrayToEmptyArrayComparisonRector::class,
    StrictArraySearchRector::class,
    VersionCompareFuncCallToConstantRector::class,
    NullableCompareToNullRector::class,
    SplitGroupedPropertiesRector::class,
    NewlineAfterStatementRector::class,
    RemoveUselessAliasInUseStatementRector::class,
    SimplifyQuoteEscapeRector::class,
    UseClassKeywordForClassNameResolutionRector::class,
    TernaryConditionVariableAssignmentRector::class,
    SeparateMultiUseImportsRector::class,
    StringClassNameToClassConstantRector::class,
    FuncCallToConstFetchRector::class,
    ExplicitPublicClassMethodRector::class,
];
