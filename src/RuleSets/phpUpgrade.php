<?php

use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Arguments\Rector\FuncCall\FunctionArgumentDefaultValueReplacerRector;
use Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\CodingStyle\Rector\ArrowFunction\ArrowFunctionDelegatingCallToFirstClassCallableRector;
use Rector\CodingStyle\Rector\Closure\ClosureDelegatingCallToFirstClassCallableRector;
use Rector\CodingStyle\Rector\FuncCall\ClosureFromCallableToFirstClassCallableRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\FuncCall\FunctionFirstClassCallableRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use Rector\Php54\Rector\Array_\LongArrayToShortArrayRector;
use Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use Rector\Php55\Rector\ClassConstFetch\StaticToSelfOnFinalClassRector;
use Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector;
use Rector\Php55\Rector\FuncCall\GetCalledClassToSelfClassRector;
use Rector\Php55\Rector\FuncCall\GetCalledClassToStaticClassRector;
use Rector\Php55\Rector\FuncCall\PregReplaceEModifierRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php56\Rector\FuncCall\PowToExpRector;
use Rector\Php70\Rector\Assign\ListSplitStringRector;
use Rector\Php70\Rector\Assign\ListSwapArrayOrderRector;
use Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector;
use Rector\Php70\Rector\ClassMethod\Php4ConstructorRector;
use Rector\Php70\Rector\FuncCall\CallUserMethodRector;
use Rector\Php70\Rector\FuncCall\EregToPregMatchRector;
use Rector\Php70\Rector\FuncCall\MultiDirnameRector;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php70\Rector\FuncCall\RenameMktimeWithoutArgsToTimeRector;
use Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector;
use Rector\Php70\Rector\If_\IfToSpaceshipRector;
use Rector\Php70\Rector\List_\EmptyListRector;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Php70\Rector\StmtsAwareInterface\IfIssetToCoalescingRector;
use Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector;
use Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use Rector\Php70\Rector\Ternary\TernaryToSpaceshipRector;
use Rector\Php70\Rector\Variable\WrapVariableVariableNameInCurlyBracesRector;
use Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector;
use Rector\Php71\Rector\BooleanOr\IsIterableRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php71\Rector\List_\ListToArrayDestructRector;
use Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector;
use Rector\Php72\Rector\FuncCall\GetClassOnNullRector;
use Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use Rector\Php72\Rector\FuncCall\StringifyDefineRector;
use Rector\Php72\Rector\FuncCall\StringsAssertNakedRector;
use Rector\Php72\Rector\Unset_\UnsetCastRector;
use Rector\Php72\Rector\While_\WhileEachToForeachRector;
use Rector\Php73\Rector\BooleanOr\IsCountableRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector;
use Rector\Php73\Rector\FuncCall\RegexDashEscapeRector;
use Rector\Php73\Rector\FuncCall\SensitiveDefineRector;
use Rector\Php73\Rector\FuncCall\SetCookieRector;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\Php73\Rector\String_\SensitiveHereNowDocRector;
use Rector\Php74\Rector\ArrayDimFetch\CurlyToSquareBracketArrayStringRector;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector;
use Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector;
use Rector\Php74\Rector\FuncCall\HebrevcToNl2brHebrevRector;
use Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector;
use Rector\Php74\Rector\FuncCall\MoneyFormatToNumberFormatRector;
use Rector\Php74\Rector\FuncCall\RestoreIncludePathToIniRestoreRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector;
use Rector\Php74\Rector\Ternary\ParenthesizeNestedTernaryRector;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\ClassConstFetch\ClassOnThisVariableObjectRector;
use Rector\Php80\Rector\ClassMethod\AddParamBasedOnParentClassMethodRector;
use Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php80\Rector\Identical\StrEndsWithRector;
use Rector\Php80\Rector\Identical\StrStartsWithRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\Php80\Rector\Ternary\GetDebugTypeRector;
use Rector\Php81\Rector\Array_\ArrayToFirstClassCallableRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;
use Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector;
use Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector;
use Rector\Php81\Rector\FuncCall\NullToStrictIntPregSlitFuncCallLimitArgRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector;
use Rector\Php81\Rector\MethodCall\RemoveReflectionSetAccessibleCallsRector;
use Rector\Php81\Rector\MethodCall\SpatieEnumMethodCallToEnumConstRector;
use Rector\Php81\Rector\New_\MyCLabsConstructorCallToEnumFromRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\Php82\Rector\Encapsed\VariableInStringInterpolationFixerRector;
use Rector\Php82\Rector\FuncCall\Utf8DecodeEncodeToMbConvertEncodingRector;
use Rector\Php82\Rector\New_\FilesystemIteratorSkipDotsRector;
use Rector\Php83\Rector\BooleanAnd\JsonValidateRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Php83\Rector\Class_\ReadOnlyAnonymousClassRector;
use Rector\Php83\Rector\FuncCall\CombineHostPortLdapUriRector;
use Rector\Php83\Rector\FuncCall\DynamicClassConstFetchRector;
use Rector\Php83\Rector\FuncCall\RemoveGetClassGetParentClassNoArgsRector;
use Rector\Php84\Rector\Class_\DeprecatedAnnotationToDeprecatedAttributeRector;
use Rector\Php84\Rector\Foreach_\ForeachToArrayAllRector;
use Rector\Php84\Rector\Foreach_\ForeachToArrayAnyRector;
use Rector\Php84\Rector\Foreach_\ForeachToArrayFindKeyRector;
use Rector\Php84\Rector\Foreach_\ForeachToArrayFindRector;
use Rector\Php84\Rector\FuncCall\AddEscapeArgumentRector;
use Rector\Php84\Rector\FuncCall\RoundingModeEnumRector;
use Rector\Php84\Rector\MethodCall\NewMethodCallWithoutParenthesesRector;
use Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector;
use Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector;
use Rector\Renaming\Rector\Cast\RenameCastRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;

return [
    ArgumentAdderRector::class,
    FunctionArgumentDefaultValueReplacerRector::class,
    OptionalParametersAfterRequiredRector::class,
    ArrowFunctionDelegatingCallToFirstClassCallableRector::class,
    ClosureDelegatingCallToFirstClassCallableRector::class,
    ClosureFromCallableToFirstClassCallableRector::class,
    ConsistentImplodeRector::class,
    FunctionFirstClassCallableRector::class,
    RemoveParentCallWithoutParentRector::class,
    VarToPublicPropertyRector::class,
    ContinueToBreakInSwitchRector::class,
    DirNameFileConstantToDirConstantRector::class,
    TernaryToElvisRector::class,
    ReplaceHttpServerVarsByServerRector::class,
    LongArrayToShortArrayRector::class,
    RemoveZeroBreakContinueRector::class,
    RemoveReferenceFromCallRector::class,
    StaticToSelfOnFinalClassRector::class,
    ClassConstantToSelfClassRector::class,
    GetCalledClassToSelfClassRector::class,
    GetCalledClassToStaticClassRector::class,
    PregReplaceEModifierRector::class,
    StringClassNameToClassConstantRector::class,
    PowToExpRector::class,
    ListSplitStringRector::class,
    ListSwapArrayOrderRector::class,
    BreakNotInLoopOrSwitchToReturnRector::class,
    Php4ConstructorRector::class,
    CallUserMethodRector::class,
    EregToPregMatchRector::class,
    MultiDirnameRector::class,
    RandomFunctionRector::class,
    RenameMktimeWithoutArgsToTimeRector::class,
    ExceptionHandlerTypehintRector::class,
    IfToSpaceshipRector::class,
    EmptyListRector::class,
    ThisCallOnStaticMethodToStaticCallRector::class,
    StaticCallOnNonStaticToInstanceCallRector::class,
    IfIssetToCoalescingRector::class,
    ReduceMultipleDefaultSwitchRector::class,
    TernaryToNullCoalescingRector::class,
    TernaryToSpaceshipRector::class,
    WrapVariableVariableNameInCurlyBracesRector::class,
    AssignArrayToStringRector::class,
    BinaryOpBetweenNumberAndStringRector::class,
    IsIterableRector::class,
    RemoveExtraParametersRector::class,
    ListToArrayDestructRector::class,
    MultiExceptionCatchRector::class,
    ListEachRector::class,
    ReplaceEachAssignmentWithKeyCurrentRector::class,
    CreateFunctionToAnonymousFunctionRector::class,
    GetClassOnNullRector::class,
    ParseStrWithResultArgumentRector::class,
    StringifyDefineRector::class,
    StringsAssertNakedRector::class,
    UnsetCastRector::class,
    WhileEachToForeachRector::class,
    IsCountableRector::class,
    SensitiveConstantNameRector::class,
    ArrayKeyFirstLastRector::class,
    RegexDashEscapeRector::class,
    SensitiveDefineRector::class,
    SetCookieRector::class,
    StringifyStrNeedlesRector::class,
    SensitiveHereNowDocRector::class,
    CurlyToSquareBracketArrayStringRector::class,
    NullCoalescingOperatorRector::class,
    ClosureToArrowFunctionRector::class,
    ArrayKeyExistsOnPropertyRector::class,
    FilterVarToAddSlashesRector::class,
    HebrevcToNl2brHebrevRector::class,
    MbStrrposEncodingArgumentPositionRector::class,
    MoneyFormatToNumberFormatRector::class,
    RestoreIncludePathToIniRestoreRector::class,
    RestoreDefaultNullToNullableTypePropertyRector::class,
    ExportToReflectionFunctionRector::class,
    ParenthesizeNestedTernaryRector::class,
    RemoveUnusedVariableInCatchRector::class,
    ClassOnThisVariableObjectRector::class,
    AddParamBasedOnParentClassMethodRector::class,
    FinalPrivateToPrivateVisibilityRector::class,
    SetStateToStaticRector::class,
    ClassPropertyAssignToConstructorPromotionRector::class,
    StringableForToStringRector::class,
    ClassOnObjectRector::class,
    StrEndsWithRector::class,
    StrStartsWithRector::class,
    StrContainsRector::class,
    ChangeSwitchToMatchRector::class,
    GetDebugTypeRector::class,
    ArrayToFirstClassCallableRector::class,
    NewInInitializerRector::class,
    MyCLabsClassToEnumRector::class,
    SpatieEnumClassToEnumRector::class,
    NullToStrictIntPregSlitFuncCallLimitArgRector::class,
    NullToStrictStringFuncCallArgRector::class,
    MyCLabsMethodCallToEnumConstRector::class,
    RemoveReflectionSetAccessibleCallsRector::class,
    SpatieEnumMethodCallToEnumConstRector::class,
    MyCLabsConstructorCallToEnumFromRector::class,
    ReadOnlyPropertyRector::class,
    ReadOnlyClassRector::class,
    VariableInStringInterpolationFixerRector::class,
    Utf8DecodeEncodeToMbConvertEncodingRector::class,
    FilesystemIteratorSkipDotsRector::class,
    JsonValidateRector::class,
    AddTypeToConstRector::class,
    AddOverrideAttributeToOverriddenMethodsRector::class,
    ReadOnlyAnonymousClassRector::class,
    CombineHostPortLdapUriRector::class,
    DynamicClassConstFetchRector::class,
    RemoveGetClassGetParentClassNoArgsRector::class,
    DeprecatedAnnotationToDeprecatedAttributeRector::class,
    ForeachToArrayAllRector::class,
    ForeachToArrayAnyRector::class,
    ForeachToArrayFindKeyRector::class,
    ForeachToArrayFindRector::class,
    AddEscapeArgumentRector::class,
    RoundingModeEnumRector::class,
    NewMethodCallWithoutParenthesesRector::class,
    ExplicitNullableParamTypeRector::class,
    RemoveFuncCallArgRector::class,
    RenameCastRector::class,
    RenameFunctionRector::class,
    StaticCallToFuncCallRector::class,
    ReturnNeverTypeRector::class,
];
