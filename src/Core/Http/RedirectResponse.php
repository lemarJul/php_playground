<?php

namespace App\Core\Http;

use App\Core\Http\Response;
use App\Core\Http\HttpStatusCode;

// Redirect Response
class RedirectResponse extends Response
{
    public function __construct($url, $statusCode = HttpStatusCode::FOUND)
    {
        parent::__construct('', $statusCode, ['Location' => $url]);
    }

    public function withFlash($key, $value)
    {
        $_SESSION['flash'][$key] = $value;
        return $this;
    }
}
