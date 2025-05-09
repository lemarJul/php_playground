<?php

declare(strict_types=1);

namespace App\Core\Http;

interface ResponseInterface
{
    public function setContent($content): self;
    public function setStatusCode(int $statusCode): self;
    public function addHeader(string $name, string $value): self;
    public function send(): void;
    public function getContent();
    public function getStatusCode(): int;
    public function getHeaders(): array;
}
