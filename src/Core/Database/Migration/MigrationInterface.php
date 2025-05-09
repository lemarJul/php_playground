<?php

declare(strict_types=1);

namespace App\Core\Database\Migration;

use PDO;

/**
 * Interface MigrationInterface
 *
 * Defines the contract for database migrations.
 *
 * @package App\Database
 */
interface MigrationInterface
{
    /**
     * Executes the migration.
     *
     * @param PDO $pdo Database connection
     */
    public function up(\PDO $pdo): void;

    /**
     * Rolls back the migration.
     *
     * @param PDO $pdo Database connection
     */
    public function down(\PDO $pdo): void;

    /**
     * Gets the migration name for tracking.
     */
    public function getName(): string;
}
