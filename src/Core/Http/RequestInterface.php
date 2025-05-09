<?php

declare(strict_types=1);

namespace App\Core\Http;

interface RequestInterface
{
    public static function createFromGlobals(): self;
    public function getMethod(): string;
    public function isMethod(string $method): bool;
    public function getUri(): string;
    public function getPath(): string;
    public function getQueryParams(): array;
    public function getQueryParam(string $key, $default = null);
    public function getRequestData(): array;
    public function get(string $key, $default = null);
    public function getHeaders(): array;
    public function getHeader(string $name, $default = null);
    public function getContent();
    public function getJsonContent(bool $assoc = true);
    public function getFiles(): array;
    public function getFile(string $key);
    public function getServerParams(): array;
    public function getServerParam(string $key, $default = null);
    public function getCookies(): array;
    public function getCookie(string $key, $default = null);
    public function isAjax(): bool;
    public function isSecure(): bool;
    public function getClientIp(): string;
}
