<?php

use Rector\CodeQuality\Rector\Class_\ReturnIteratorInDataProviderRector;
use Rector\Symfony\CodeQuality\Rector\ClassMethod\ResponseReturnTypeControllerActionRector;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamFromDimFetchKeyUseRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamStringTypeFromSprintfUseRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeBasedOnPHPUnitDataProviderRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeFromPropertyTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationBasedOnParentClassMethodRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeFromTryCatchTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromBooleanConstReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromBooleanStrictReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\KnownMagicClassMethodTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\NarrowObjectReturnTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\NumericReturnTypeFromStrictReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\NumericReturnTypeFromStrictScalarReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByParentCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNullableTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromMockObjectRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnCastRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictConstantReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictFluentReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNativeCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictParamRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromSymfonySerializerRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnUnionTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictArrayParamDimFetchRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictStringParamConcatRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StringReturnTypeFromStrictScalarReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StringReturnTypeFromStrictStringReturnsRector;
use Rector\TypeDeclaration\Rector\Class_\AddTestsVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Class_\ChildDoctrineRepositoryClassTypeRector;
use Rector\TypeDeclaration\Rector\Class_\MergeDateTimePropertyTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\Class_\ObjectTypedPropertyFromJMSSerializerAttributeTypeRector;
use Rector\TypeDeclaration\Rector\Class_\PropertyTypeFromStrictSetterGetterRector;
use Rector\TypeDeclaration\Rector\Class_\ReturnTypeFromStrictTernaryRector;
use Rector\TypeDeclaration\Rector\Class_\ScalarTypedPropertyFromJMSSerializerAttributeTypeRector;
use Rector\TypeDeclaration\Rector\Class_\TypedPropertyFromCreateMockAssignRector;
use Rector\TypeDeclaration\Rector\Class_\TypedPropertyFromDocblockSetUpDefinedRector;
use Rector\TypeDeclaration\Rector\Class_\TypedStaticPropertyInBehatContextRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureNeverReturnTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Closure\ClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\Empty_\EmptyOnNullableObjectToInstanceOfRector;
use Rector\TypeDeclaration\Rector\FuncCall\AddArrayFunctionClosureParamTypeRector;
use Rector\TypeDeclaration\Rector\FuncCall\AddArrowFunctionParamArrayWhereDimFetchRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddClosureParamTypeForArrayMapRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddClosureParamTypeForArrayReduceRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddClosureParamTypeFromIterableMethodCallRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddParamTypeSplFixedArrayRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddReturnTypeDeclarationFromYieldsRector;
use Rector\TypeDeclaration\Rector\Function_\AddFunctionVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictSetUpRector;

return [
    ReturnIteratorInDataProviderRector::class,
    ResponseReturnTypeControllerActionRector::class,
    AddArrowFunctionReturnTypeRector::class,
    AddMethodCallBasedStrictParamTypeRector::class,
    AddParamFromDimFetchKeyUseRector::class,
    AddParamStringTypeFromSprintfUseRector::class,
    AddParamTypeBasedOnPHPUnitDataProviderRector::class,
    AddParamTypeFromPropertyTypeRector::class,
    AddReturnTypeDeclarationBasedOnParentClassMethodRector::class,
    AddReturnTypeFromTryCatchTypeRector::class,
    AddVoidReturnTypeWhereNoReturnRector::class,
    BoolReturnTypeFromBooleanConstReturnsRector::class,
    BoolReturnTypeFromBooleanStrictReturnsRector::class,
    KnownMagicClassMethodTypeRector::class,
    NarrowObjectReturnTypeRector::class,
    NumericReturnTypeFromStrictReturnsRector::class,
    NumericReturnTypeFromStrictScalarReturnsRector::class,
    ParamTypeByMethodCallTypeRector::class,
    ParamTypeByParentCallTypeRector::class,
    ReturnNeverTypeRector::class,
    ReturnNullableTypeRector::class,
    ReturnTypeFromMockObjectRector::class,
    ReturnTypeFromReturnCastRector::class,
    ReturnTypeFromReturnDirectArrayRector::class,
    ReturnTypeFromReturnNewRector::class,
    ReturnTypeFromStrictConstantReturnRector::class,
    ReturnTypeFromStrictFluentReturnRector::class,
    ReturnTypeFromStrictNativeCallRector::class,
    ReturnTypeFromStrictNewArrayRector::class,
    ReturnTypeFromStrictParamRector::class,
    ReturnTypeFromStrictTypedCallRector::class,
    ReturnTypeFromStrictTypedPropertyRector::class,
    ReturnTypeFromSymfonySerializerRector::class,
    ReturnUnionTypeRector::class,
    StrictArrayParamDimFetchRector::class,
    StrictStringParamConcatRector::class,
    StringReturnTypeFromStrictScalarReturnsRector::class,
    StringReturnTypeFromStrictStringReturnsRector::class,
    AddTestsVoidReturnTypeWhereNoReturnRector::class,
    ChildDoctrineRepositoryClassTypeRector::class,
    MergeDateTimePropertyTypeDeclarationRector::class,
    ObjectTypedPropertyFromJMSSerializerAttributeTypeRector::class,
    PropertyTypeFromStrictSetterGetterRector::class,
    ReturnTypeFromStrictTernaryRector::class,
    ScalarTypedPropertyFromJMSSerializerAttributeTypeRector::class,
    TypedPropertyFromCreateMockAssignRector::class,
    TypedPropertyFromDocblockSetUpDefinedRector::class,
    TypedStaticPropertyInBehatContextRector::class,
    AddClosureNeverReturnTypeRector::class,
    AddClosureVoidReturnTypeWhereNoReturnRector::class,
    ClosureReturnTypeRector::class,
    EmptyOnNullableObjectToInstanceOfRector::class,
    AddArrayFunctionClosureParamTypeRector::class,
    AddArrowFunctionParamArrayWhereDimFetchRector::class,
    AddClosureParamTypeForArrayMapRector::class,
    AddClosureParamTypeForArrayReduceRector::class,
    AddClosureParamTypeFromIterableMethodCallRector::class,
    AddParamTypeSplFixedArrayRector::class,
    AddReturnTypeDeclarationFromYieldsRector::class,
    AddFunctionVoidReturnTypeWhereNoReturnRector::class,
    TypedPropertyFromAssignsRector::class,
    TypedPropertyFromStrictConstructorRector::class,
    TypedPropertyFromStrictSetUpRector::class,
];
