<?php

namespace RectorIntegrationTool\database;

use PDO;

class RectorIntegrateDb
{
    private PDO $pdo;

    public function __construct(?string $dbPath = null)
    {
        if ($dbPath === null) {
            $dbPath = __DIR__ . '/database.sqlite';
        }
        $this->pdo = new PDO("sqlite:$dbPath");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function addNotReviewedRule(string $ruleName, string $project): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT OR IGNORE INTO not_reviewed_rules (rule_name, project) 
            VALUES (?, ?)
        ");
        return $stmt->execute([$ruleName, $project]);
    }

    public function isRuleReviewed(string $ruleName): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM reviewed_rules WHERE rule_name = ?
        ");
        $stmt->execute([$ruleName]);
        return $stmt->fetchColumn() > 0;
    }

    public function getAllRecords(string $table): array {
        $stmt = $this->pdo->prepare("SELECT id, rule_name, project FROM $table ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function moveToReviewed(string $ruleName): bool
    {
        $this->pdo->beginTransaction();
        try {
            // Get the rule from not_reviewed_rules
            $stmt = $this->pdo->prepare("SELECT rule_name, project FROM not_reviewed_rules WHERE rule_name = ?");
            $stmt->execute([$ruleName]);
            $rule = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$rule) {
                $this->pdo->rollBack();
                return false;
            }

            // Add to reviewed_rules
            $stmt = $this->pdo->prepare("INSERT OR IGNORE INTO reviewed_rules (rule_name, project) VALUES (?, ?)");
            $stmt->execute([$rule['rule_name'], $rule['project']]);

            // Remove from not_reviewed_rules
            $stmt = $this->pdo->prepare("DELETE FROM not_reviewed_rules WHERE rule_name = ?");
            $stmt->execute([$ruleName]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function moveAllToReviewed(): int
    {
        $this->pdo->beginTransaction();
        try {
            // Move all rules
            $this->pdo->exec("
            INSERT OR IGNORE INTO reviewed_rules (rule_name, project) 
            SELECT rule_name, project FROM not_reviewed_rules
        ");

            // Count moved rules
            $count = $this->pdo->query("SELECT COUNT(*) FROM not_reviewed_rules")->fetchColumn();

            // Clear not_reviewed_rules
            $this->pdo->exec("DELETE FROM not_reviewed_rules");

            $this->pdo->commit();
            return $count;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return 0;
        }
    }
}

(new RectorIntegrateDb())->moveAllToReviewed();
