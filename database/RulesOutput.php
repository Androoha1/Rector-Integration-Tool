<?php

$table = ($argv[1] ?? '') === '--reviewed' ? 'reviewed_rules' : 'not_reviewed_rules';
$label = $table === 'reviewed_rules' ? 'reviewed' : 'not-reviewed';

$pdo = new PDO("sqlite:database/database.sqlite");
$rules = $pdo->query("SELECT id, rule_name, project FROM $table ORDER BY project, rule_name")->fetchAll();

if (empty($rules)) {
    echo "No $label rules found.\n";
    exit;
}

echo "ID\tProject\t\tRule Name ($label)\n" . str_repeat("-", 60) . "\n";
foreach ($rules as $rule) {
    $shortRule = basename(str_replace('\\', '/', $rule['rule_name']));
    printf("%d\t%-10s\t%s\n", $rule['id'], $rule['project'], $shortRule);
}
echo "\nTotal: " . count($rules) . " $label rules\n";
