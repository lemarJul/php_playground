<?php

declare(strict_types=1);

namespace App\Core\Database;

use PDO;
use App\Core\Database\Connection\DatabaseFactory;

/**
 * Centralized database connection provider
 */
final class DatabaseProvider
{
    private ?PDO $connection = null;

    public function __construct(
        private DatabaseConfigLoader $configLoader,
        private DatabaseFactory $factory
    ) {
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $config = $this->configLoader->getConfig();
            $this->connection = $this->factory->create($config);
        }
        return $this->connection;
    }
}
