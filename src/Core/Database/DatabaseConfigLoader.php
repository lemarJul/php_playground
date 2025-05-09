<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\RuntimeEnvironment;

/**
 * Class DatabaseConfigLoader
 *
 * This class is responsible for loading database configuration based on the current environment.
 */
class DatabaseConfigLoader
{
    /**
     * Get the database configuration for the current environment.
     *
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getConfig(): array
    {
        $configFile = $this->getConfigFilePath(RuntimeEnvironment::getEnv());
        return require $configFile;
    }

    /**
     * Get the file path for the database configuration based on the environment.
     *
     * @param string $env
     * @return string
     * @throws \RuntimeException
     */
    private function getConfigFilePath(string $env): string
    {
        $basePath = dirname(__DIR__, 3) . '/config/';
        $envFile = match ($env) {
            RuntimeEnvironment::ENV_PROD => 'prod/database.php',
            RuntimeEnvironment::ENV_TEST  => 'test/database.php',
            default => 'dev/database.php'
        };

        $fullPath = $basePath . $envFile;
        if (!file_exists($fullPath)) {
            throw new \RuntimeException("Database config file not found: $fullPath");
        }

        return $fullPath;
    }
}
