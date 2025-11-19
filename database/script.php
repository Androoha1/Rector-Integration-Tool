<?php
require_once '../vendor/autoload.php';

use RectorIntegrationTool\database\RectorIntegrateDb;

$commonDb = new RectorIntegrateDb(__DIR__ . '/database.sqlite');
$wwwDb = new RectorIntegrateDb(__DIR__ . '/www_database.sqlite');

$notReviewedOne = $wwwDb->getAllRecords("not_reviewed_rules");

$i = 0;
foreach ($notReviewedOne as $notReviewedOneRecord) {
    if (!$commonDb->isRuleReviewed($notReviewedOneRecord['rule_name']) && !$commonDb->isRuleReviewed(basename($notReviewedOneRecord['rule_name']))) {
        echo $i++ . '. ' . basename($notReviewedOneRecord['rule_name']) . "\n";
    }
}
