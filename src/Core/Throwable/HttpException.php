<?php

namespace App\Core\Throwable;

use App\Core\Router\HTTP\HttpStatusCode;

class HttpException extends \Exception
{
    protected $httpCode;
    protected $additionalData = [];

    public function __construct(int $httpCode, ?string $message = null, array $additionalData = [], ?\Throwable $previous = null)
    {
        $this->httpCode = $httpCode;
        $this->additionalData = $additionalData;

        if ($message === null) {
            $message = HttpStatusCode::getMessage($httpCode) ?? 'Unknown HTTP Error';
        }

        parent::__construct(message: $message, code: $httpCode, previous: $previous);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    public function setAdditionalData(array $data): self
    {
        $this->additionalData = $data;
        return $this;
    }

    public function addData(string $key, $value): self
    {
        $this->additionalData[$key] = $value;
        return $this;
    }

    public function toArray(bool $includeTrace = false): array
    {
        $response = [
            'error' => true,
            'code' => $this->httpCode,
            'message' => $this->getMessage()
        ];

        if (!empty($this->additionalData)) {
            $response['details'] = $this->additionalData;
        }

        if ($includeTrace) {
            $response['trace'] = $this->getTraceAsString();
        }

        return $response;
    }

    public function send(bool $asJson = true, bool $includeTrace = false): void
    {
        http_response_code($this->httpCode);

        if ($asJson) {
            header('Content-Type: application/json');
            echo json_encode($this->toArray($includeTrace));
        } else {
            echo $this->getMessage();
            if ($includeTrace) {
                echo "\n\nTrace: " . $this->getTraceAsString();
            }
        }
    }

    public static function badRequest(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::BAD_REQUEST, $message, $data);
    }

    public static function unauthorized(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::UNAUTHORIZED, $message, $data);
    }

    public static function forbidden(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::FORBIDDEN, $message, $data);
    }

    public static function notFound(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::NOT_FOUND, $message, $data);
    }

    public static function methodNotAllowed(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::METHOD_NOT_ALLOWED, $message, $data);
    }

    public static function conflict(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::CONFLICT, $message, $data);
    }

    public static function validationError(?string $message = null, array $errors = []): self
    {
        return new self(HttpStatusCode::UNPROCESSABLE_ENTITY, $message ?? 'Validation Error', ['errors' => $errors]);
    }

    public static function tooManyRequests(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::TOO_MANY_REQUESTS, $message, $data);
    }

    public static function internalError(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::INTERNAL_SERVER_ERROR, $message, $data);
    }

    public static function serviceUnavailable(?string $message = null, array $data = []): self
    {
        return new self(HttpStatusCode::SERVICE_UNAVAILABLE, $message, $data);
    }
}
