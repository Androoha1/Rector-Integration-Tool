<?php

use Rector\PHPUnit\CodeQuality\Rector\ClassMethod\AddInstanceofAssertForNullableInstanceRector;
use Rector\PHPUnit\CodeQuality\Rector\ClassMethod\DataProviderArrayItemsNewLinedRector;
use Rector\PHPUnit\CodeQuality\Rector\ClassMethod\EntityDocumentCreateMockToDirectNewRector;
use Rector\PHPUnit\CodeQuality\Rector\ClassMethod\RemoveEmptyTestMethodRector;
use Rector\PHPUnit\CodeQuality\Rector\ClassMethod\ReplaceTestAnnotationWithPrefixedFunctionRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\AddParamTypeFromDependsRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\AddReturnTypeToDependedRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\ConstructClassMethodToSetUpTestCaseRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\NarrowUnusedSetUpDefinedPropertyRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\SingleMockPropertyTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\TestWithToDataProviderRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\TypeWillReturnCallableArrowFunctionRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\YieldDataProviderRector;
use Rector\PHPUnit\CodeQuality\Rector\Expression\AssertArrayCastedObjectToAssertSameRector;
use Rector\PHPUnit\CodeQuality\Rector\Foreach_\SimplifyForeachInstanceOfRector;
use Rector\PHPUnit\CodeQuality\Rector\FuncCall\AssertFuncCallToPHPUnitAssertRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertCompareOnCountableWithMethodToAssertCountRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertComparisonToSpecificMethodRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertEmptyNullableObjectToAssertInstanceofRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertEqualsOrAssertSameFloatParameterToSpecificMethodsTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertEqualsToSameRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertFalseStrposToContainsRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertInstanceOfComparisonRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertIssetToSpecificMethodRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertNotOperatorRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertRegExpRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertSameBoolNullToSpecificMethodRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertTrueFalseToSpecificMethodRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\FlipAssertRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\MatchAssertSameExpectedTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\MergeWithCallableAndWillReturnRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\NarrowIdenticalWithConsecutiveRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\NarrowSingleWillReturnCallbackRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\ScalarArgumentToExpectedParamTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\SimplerWithIsInstanceOfRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\SingleWithConsecutiveToWithRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\StringCastAssertStringContainsStringRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\UseSpecificWillMethodRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\UseSpecificWithMethodRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\WithCallbackIdenticalToStandaloneAssertsRector;
use Rector\PHPUnit\CodeQuality\Rector\StmtsAwareInterface\DeclareStrictTypesTestsRector;
use Rector\PHPUnit\PHPUnit60\Rector\MethodCall\GetMockBuilderGetMockToCreateMockRector;
use Rector\PHPUnit\PHPUnit90\Rector\MethodCall\ReplaceAtMethodWithDesiredMatcherRector;
use Rector\Privatization\Rector\Class_\FinalizeTestCaseClassRector;

return [
    AddInstanceofAssertForNullableInstanceRector::class,
    DataProviderArrayItemsNewLinedRector::class,
    EntityDocumentCreateMockToDirectNewRector::class,
    RemoveEmptyTestMethodRector::class,
    ReplaceTestAnnotationWithPrefixedFunctionRector::class,
    AddParamTypeFromDependsRector::class,
    AddReturnTypeToDependedRector::class,
    ConstructClassMethodToSetUpTestCaseRector::class,
    NarrowUnusedSetUpDefinedPropertyRector::class,
    PreferPHPUnitThisCallRector::class,
    SingleMockPropertyTypeRector::class,
    TestWithToDataProviderRector::class,
    TypeWillReturnCallableArrowFunctionRector::class,
    YieldDataProviderRector::class,
    AssertArrayCastedObjectToAssertSameRector::class,
    SimplifyForeachInstanceOfRector::class,
    AssertFuncCallToPHPUnitAssertRector::class,
    AssertCompareOnCountableWithMethodToAssertCountRector::class,
    AssertComparisonToSpecificMethodRector::class,
    AssertEmptyNullableObjectToAssertInstanceofRector::class,
    AssertEqualsOrAssertSameFloatParameterToSpecificMethodsTypeRector::class,
    AssertEqualsToSameRector::class,
    AssertFalseStrposToContainsRector::class,
    AssertInstanceOfComparisonRector::class,
    AssertIssetToSpecificMethodRector::class,
    AssertNotOperatorRector::class,
    AssertRegExpRector::class,
    AssertSameBoolNullToSpecificMethodRector::class,
    AssertSameTrueFalseToAssertTrueFalseRector::class,
    AssertTrueFalseToSpecificMethodRector::class,
    FlipAssertRector::class,
    MatchAssertSameExpectedTypeRector::class,
    MergeWithCallableAndWillReturnRector::class,
    NarrowIdenticalWithConsecutiveRector::class,
    NarrowSingleWillReturnCallbackRector::class,
    RemoveExpectAnyFromMockRector::class,
    ScalarArgumentToExpectedParamTypeRector::class,
    SimplerWithIsInstanceOfRector::class,
    SingleWithConsecutiveToWithRector::class,
    StringCastAssertStringContainsStringRector::class,
    UseSpecificWillMethodRector::class,
    UseSpecificWithMethodRector::class,
    WithCallbackIdenticalToStandaloneAssertsRector::class,
    DeclareStrictTypesTestsRector::class,
    GetMockBuilderGetMockToCreateMockRector::class,
    ReplaceAtMethodWithDesiredMatcherRector::class,
    FinalizeTestCaseClassRector::class,
];
