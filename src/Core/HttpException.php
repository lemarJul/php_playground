<?php

namespace App\Core;

/**
 * Class HttpException
 *
 * A class to handle HTTP exceptions clearly and consistently.
 * Allows for easy creation of exceptions with standard HTTP status codes
 * and uniform handling.
 */
class HttpException extends \Exception
{
    /**
     * Standard HTTP status codes with their messages
     */
    public const HTTP_CODES = [
        // 4xx - Client errors
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        413 => 'Payload Too Large',
        415 => 'Unsupported Media Type',
        422 => 'Unprocessable Entity',
        429 => 'Too Many Requests',

        // 5xx - Server errors
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    ];

    /**
     * HTTP error code
     * @var int
     */
    protected $httpCode;
    /**
     * Additional data related to the error
     * @var array
     */
    protected $additionalData = [];

    /**
     * Constructor
     *
     * @param int $httpCode HTTP error code
     * @param string|null $message Custom message (optional)
     * @param array $additionalData Additional data (optional)
     * @param \Throwable|null $previous Previous exception (optional)
     */
    public function __construct(int $httpCode, ?string $message = null, array $additionalData = [], ?\Throwable $previous = null)
    {
        $this->httpCode = $httpCode;
        $this->additionalData = $additionalData;

        // Use the standard message for this code if no custom message is provided
        if ($message === null) {
            $message = isset(self::HTTP_CODES[$httpCode])
                ? self::HTTP_CODES[$httpCode]
                : 'Unknown HTTP Error';
        }

        parent::__construct(message: $message, code: $httpCode, previous: $previous);
    }

    /**
     * Get the HTTP code
     *
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Get the additional data
     *
     * @return array
     */
    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    /**
     * Set the additional data
     *
     * @param array $data
     * @return $this
     */
    public function setAdditionalData(array $data): self
    {
        $this->additionalData = $data;
        return $this;
    }

    /**
     * Add additional data
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function addData(string $key, $value): self
    {
        $this->additionalData[$key] = $value;
        return $this;
    }

    /**
     * Create a formatted response for the error
     *
     * @param bool $includeTrace Include the error trace (debugging only)
     * @return array
     */
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

    /**
     * Send the HTTP headers and the error response body
     *
     * @param bool $asJson Send the response in JSON format
     * @param bool $includeTrace Include the error trace in the response
     * @return void
     */
    public function send(bool $asJson = true, bool $includeTrace = false): void
    {
        // Set the HTTP status code
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

    /**
     * Factory methods to easily create common HTTP exceptions
     */

    public static function badRequest(?string $message = null, array $data = []): self
    {
        return new self(400, $message, $data);
    }

    public static function unauthorized(?string $message = null, array $data = []): self
    {
        return new self(401, $message, $data);
    }

    public static function forbidden(?string $message = null, array $data = []): self
    {
        return new self(403, $message, $data);
    }

    public static function notFound(?string $message = null, array $data = []): self
    {
        return new self(404, $message, $data);
    }

    public static function methodNotAllowed(?string $message = null, array $data = []): self
    {
        return new self(405, $message, $data);
    }

    public static function conflict(?string $message = null, array $data = []): self
    {
        return new self(409, $message, $data);
    }

    public static function validationError(?string $message = null, array $errors = []): self
    {
        return new self(422, $message ?? 'Validation Error', ['errors' => $errors]);
    }

    public static function tooManyRequests(?string $message = null, array $data = []): self
    {
        return new self(429, $message, $data);
    }

    public static function internalError(?string $message = null, array $data = []): self
    {
        return new self(500, $message, $data);
    }

    public static function serviceUnavailable(?string $message = null, array $data = []): self
    {
        return new self(503, $message, $data);
    }
}
