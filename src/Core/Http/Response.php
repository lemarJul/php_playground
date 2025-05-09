<?php

namespace App\Core\Http;

use App\Core\Http\HttpStatusCode;

class Response implements ResponseInterface
{
    protected $content;
    protected int $statusCode;
    protected array $headers = [];

    public function __construct($content = '', int $statusCode = HttpStatusCode::OK, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function setContent($content): ResponseInterface
    {
        $this->content = $content;
        return $this;
    }

    public function setStatusCode(int $statusCode): ResponseInterface
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function addHeader(string $name, string $value): ResponseInterface
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        echo $this->content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
