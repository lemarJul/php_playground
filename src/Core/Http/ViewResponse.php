<?php

namespace App\Core\Http;

use App\Core\View\View;
use App\Core\Http\Response;
use App\Core\Http\HttpStatusCode;

class ViewResponse extends Response
{
    public function __construct(string $view, array $data = [], $statusCode = HttpStatusCode::OK)
    {
        $content = View::make($view, $data)->render();
        parent::__construct($content, $statusCode, ['Content-Type' => 'text/html']);
    }
}
