<?php

use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\Privatization\Rector\Class_\FinalizeTestCaseClassRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return [
    PostIncDecToPreIncDecRector::class,
    FinalizeTestCaseClassRector::class,
    DeclareStrictTypesRector::class,
];
