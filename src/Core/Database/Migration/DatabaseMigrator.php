<?php

declare(strict_types=1);

namespace App\Core\Database\Migration;

use PDO;
use App\Core\Database\Migration\ModelMigration;
use App\Core\Database\Schema\SchemaGenerator;

class DatabaseMigrator
{
    private array $migrations = [];

    public function __construct(private PDO $pdo, private SchemaGenerator $schemaGenerator) {}

    public function addMigration(MigrationInterface|string $migration): void
    {
        if (is_string($migration)) {
            // Assume it's a model class name
            $migration = new ModelMigration($migration, $this->schemaGenerator);
        }
        $this->migrations[] = $migration;
    }

    public function migrate(): void
    {
        // Create migrations table if not exists
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )');

        foreach ($this->migrations as $migration) {
            $name = $migration->getName();

            // Check if migration already ran
            $stmt = $this->pdo->prepare("SELECT 1 FROM migrations WHERE migration = ?");
            $stmt->execute([$name]);
            if (!$stmt->fetchColumn()) {
                $migration->up($this->pdo);
                $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
                $stmt->execute([$name]);
            }
        }
    }

    public function rollbackLast(): void
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations ORDER BY executed_at DESC LIMIT 1");
        $stmt->execute();
        if ($name = $stmt->fetchColumn()) {
            foreach ($this->migrations as $migration) {
                if ($migration->getName() === $name) {
                    $migration->down($this->pdo);
                    $stmt = $this->pdo->prepare("DELETE FROM migrations WHERE migration = ?");
                    $stmt->execute([$name]);
                    break;
                }
            }
        }
    }
}
