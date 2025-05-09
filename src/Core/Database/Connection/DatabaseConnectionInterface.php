<?php

declare(strict_types=1);

namespace App\Core\Database\Connection;

use PDO;

interface DatabaseConnectionInterface
{
    public function getConnection(): PDO;
    public function closeConnection(): void;
}
