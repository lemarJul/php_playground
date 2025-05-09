<?php

declare(strict_types=1);

namespace App\Core\Database\Migration;

use App\Core\Database\Migration\MigrationInterface;
use App\Core\Database\Schema\SchemaGenerator;

class ModelMigration implements MigrationInterface
{
    // phpcs:disable
    public function __construct(
        private string $modelClass,
        private SchemaGenerator $schemaGenerator
    ) {}

    public function up(\PDO $pdo): void
    {
        $sql = $this->generateUpSql();
        $pdo->exec($sql);
    }

    public function down(\PDO $pdo): void
    {
        $sql = $this->generateDownSql();
        $pdo->exec($sql);
    }

    public function getName(): string
    {
        $schema = $this->schemaGenerator->generateFromModel($this->modelClass);
        return "create_{$schema['table']}_table";
    }

    private function generateUpSql(): string
    {
        $schema = $this->schemaGenerator->generateFromModel($this->modelClass);
        $columns = [];

        foreach ($schema['columns'] as $name => $def) {
            $column = "`$name` {$def['type']}";
            $column .= $def['nullable'] ? ' NULL' : ' NOT NULL';
            if ($def['primary']) {
                $column .= ' PRIMARY KEY AUTO_INCREMENT';
            }
            if ($def['foreignKey']) {
                $column .= ", FOREIGN KEY (`$name`) REFERENCES {$def['foreignKey']}";
            }
            $columns[] = $column;
        }

        return sprintf(
            "CREATE TABLE IF NOT EXISTS %s (%s)",
            $schema['table'],
            implode(', ', $columns)
        );
    }

    private function generateDownSql(): string
    {
        $schema = $this->schemaGenerator->generateFromModel($this->modelClass);
        return "DROP TABLE IF EXISTS {$schema['table']}";
    }
}
