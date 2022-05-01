<?php

namespace App\Http;

class Response
{
    public array $data = [];
    public int $code = 200;

    public function __construct(array $response)
    {
        $this->data = $response['data'] ?? [];
        $this->code = $response['code'];
    }

    public function json(): string
    {
        return json_encode(array(
            'code' => $this->code,
            'data' => $this->data,
        ));
    }
}