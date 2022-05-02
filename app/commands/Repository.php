<?php

namespace App\Commands;

use App\Http\Request;
use App\Enums\HttpMethodEnum;
use App\Http\Response;

class Repository
{
    public static function create(string $name): string
    {
        $requestData = [
            'uri' => $_ENV['CREATE_URL'],
            'data' => ['name' => $name],
        ];
        $response = Request::send(HttpMethodEnum::Post->value, $requestData);

        return (new Response($response))->json();
    }

    public static function delete(string $name): string
    {
        $requestData = [
            'uri' => $_ENV['DELETE_URL'] . $_ENV['USERNAME'] . DIRECTORY_SEPARATOR . $name,
        ];
        $response = Request::send(HttpMethodEnum::Delete->value, $requestData);

        return (new Response($response))->json();
    }
}