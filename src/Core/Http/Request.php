<?php

declare(strict_types=1);

namespace App\Core\Http;

class Request implements RequestInterface
{
    private array $queryParams;
    private array $requestData;
    private array $server;
    private array $cookies;
    private array $files;
    private array $headers;
    private $content;

    public function __construct(
        array $queryParams = [],
        array $requestData = [],
        array $server = [],
        array $cookies = [],
        array $files = [],
        array $headers = [],
        $content = null
    ) {
        $this->queryParams = $queryParams;
        $this->requestData = $requestData;
        $this->server = $server;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->headers = $headers;
        $this->content = $content;
    }

    public static function createFromGlobals(): self
    {
        return new self(
            $_GET,
            $_POST,
            $_SERVER,
            $_COOKIE,
            $_FILES,
            getallheaders(),
            file_get_contents('php://input')
        );
    }

    // HTTP Method
    public function getMethod(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function isMethod(string $method): bool
    {
        return $this->getMethod() === strtoupper($method);
    }

    // URI
    public function getUri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public function getPath(): string
    {
        return parse_url($this->getUri(), PHP_URL_PATH) ?? '/';
    }

    // Parameters
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getQueryParam(string $key, $default = null)
    {
        return $this->queryParams[$key] ?? $default;
    }

    public function getRequestData(): array
    {
        return $this->requestData;
    }

    public function get(string $key, $default = null)
    {
        if ($this->isMethod('GET')) {
            return $this->getQueryParam($key, $default);
        }
        return $this->requestData[$key] ?? $default;
    }

    // Headers
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name, $default = null)
    {
        $name = strtolower($name);
        foreach ($this->headers as $key => $value) {
            if (strtolower($key) === $name) {
                return $value;
            }
        }
        return $default;
    }

    // Content
    public function getContent()
    {
        return $this->content;
    }

    public function getJsonContent(bool $assoc = true)
    {
        return json_decode($this->content, $assoc);
    }

    // Files
    public function getFiles(): array
    {
        return $this->files;
    }

    public function getFile(string $key)
    {
        return $this->files[$key] ?? null;
    }

    // Server
    public function getServerParams(): array
    {
        return $this->server;
    }

    public function getServerParam(string $key, $default = null)
    {
        return $this->server[$key] ?? $default;
    }

    // Cookies
    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getCookie(string $key, $default = null)
    {
        return $this->cookies[$key] ?? $default;
    }

    // Helpers
    public function isAjax(): bool
    {
        return 'XMLHttpRequest' === $this->getHeader('X-Requested-With');
    }

    public function isSecure(): bool
    {
        return (!empty($this->server['HTTPS']) && $this->server['HTTPS'] !== 'off')
            || ($this->server['SERVER_PORT'] ?? null) === 443;
    }

    public function getClientIp(): string
    {
        return $this->server['HTTP_CLIENT_IP']
            ?? $this->server['HTTP_X_FORWARDED_FOR']
            ?? $this->server['REMOTE_ADDR']
            ?? '';
    }
}
