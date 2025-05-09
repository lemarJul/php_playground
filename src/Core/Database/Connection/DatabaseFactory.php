<?php

declare(strict_types=1);

namespace App\Core\Database\Connection;

use PDO;
use PDOException;

class DatabaseFactory implements DatabaseConnectionInterface
{
    private ?PDO $connection = null;
    private array $config;

    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->validateConfig($config);
            $this->config = $config;
        }
    }

    public function create(array $config): PDO
    {
        $this->validateConfig($config);
        $this->config = $config;
        return $this->getConnection();
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $this->connection = $this->createNewConnection();
        }
        return $this->connection;
    }

    public function closeConnection(): void
    {
        $this->connection = null;
    }

    private function createNewConnection(): PDO
    {
        $dsn = $this->buildDsn();

        try {
            $pdo = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                $this->getPdoOptions()
            );

            $this->configureConnection($pdo);
            return $pdo;
        } catch (PDOException $e) {
            throw new DatabaseConnectionException(
                'Database connection failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    private function buildDsn(): string
    {
        return isset($this->config['unix_socket'])
            ? "mysql:unix_socket={$this->config['unix_socket']};dbname={$this->config['dbname']};charset=utf8mb4"
            : "mysql:host={$this->config['host']};dbname={$this->config['dbname']};charset=utf8mb4";
    }

    private function getPdoOptions(): array
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => $this->config['persistent'] ?? false,
        ];
    }

    private function configureConnection(PDO $pdo): void
    {
        // Set timezone if specified
        if (isset($this->config['timezone'])) {
            $pdo->exec("SET time_zone = '{$this->config['timezone']}'");
        }
    }

    private function validateConfig(array $config): void
    {
        $required = ['dbname', 'username'];
        foreach ($required as $key) {
            if (!isset($config[$key])) {
                throw new \InvalidArgumentException("Missing required database config: $key");
            }
        }
    }
}
