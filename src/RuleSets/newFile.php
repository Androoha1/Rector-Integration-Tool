<?php

$rectorRules = [

    'Php52' => [
        'Rector\Php52\Rector\Property\VarToPublicPropertyRector',
    ],

    'Php71' => [
        'Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector',
    ],

    'Symfony' => [
        'Rector\Symfony\CodeQuality\Rector\ClassMethod\ResponseReturnTypeControllerActionRector',
    ],
];
