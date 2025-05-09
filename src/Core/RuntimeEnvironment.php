<?php

namespace App\Core;

class RuntimeEnvironment
{
    public const ENV_DEV = 'development';
    public const ENV_TEST = 'test';
    public const ENV_PROD = 'production';

    public static function getEnv(): string
    {
        return self::validateEnv(
            strtolower(getenv('APP_ENV') ?: self::ENV_DEV)
        );
    }

    private static function validateEnv($env): string
    {
        if (!in_array($env, [self::ENV_DEV, self::ENV_TEST, self::ENV_PROD])) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid environment "%s". Allowed values are: %s',
                $env,
                implode(', ', [self::ENV_DEV, self::ENV_TEST, self::ENV_PROD])
            ));
        }

        return $env;
    }

    public static function isDev(): bool
    {
        return self::getEnv() === self::ENV_DEV;
    }

    public static function isTest(): bool
    {
        return self::getEnv() === self::ENV_TEST;
    }

    public static function isProd(): bool
    {
        return self::getEnv() === self::ENV_PROD;
    }
}
