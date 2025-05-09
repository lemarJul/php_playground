<?php

namespace App\Core\Http;

class HttpStatusCode
{
    // HTTP Status Codes
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NO_CONTENT = 204;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const NOT_MODIFIED = 304;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const REQUEST_TIMEOUT = 408;
    const CONFLICT = 409;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const PAYLOAD_TOO_LARGE = 413;
    const URI_TOO_LONG = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const I_AM_A_TEAPOT = 418;
    const UNPROCESSABLE_ENTITY = 422;
    const UPGRADE_REQUIRED = 426;
    const TOO_MANY_REQUESTS = 429;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;

    // Method to get the status message for a given code
    public static function getMessage($code)
    {
        $statusMessages = [
            // 2xx - Success
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            204 => 'No Content',
            // 3xx - Redirection
            301 => 'Moved Permanently',
            302 => 'Found',
            304 => 'Not Modified',
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
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            422 => 'Unprocessable Entity',
            426 => 'Upgrade Required',
            429 => 'Too Many Requests',
            // 5xx - Server errors
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
        ];

        return $statusMessages[$code] ?? 'Unknown Status';
    }
}
