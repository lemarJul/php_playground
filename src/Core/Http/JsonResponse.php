<?php

namespace App\Core\Http;

use App\Core\Http\Response;
use App\Core\Http\HttpStatusCode;

// JSON Response
class JsonResponse extends Response
{
    public function __construct($data, $statusCode = HttpStatusCode::OK)
    {
        $content = json_encode($data);
        parent::__construct($content, $statusCode, ['Content-Type' => 'application/json']);
    }
}
