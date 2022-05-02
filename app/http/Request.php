<?php

namespace App\Http;

class Request
{
    public static function send(string $method, array $requestData): array
    {
        return self::$method($requestData);
    }

    private static function get(array $requestData): array
    {
        $curl = self::make_curl($requestData['uri']);
        return self::execute($curl);
    }

    private static function post(array $requestData): array
    {
        $curl = self::make_curl($requestData['uri']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestData['data']));

        return self::execute($curl);
    }

    private static function delete(array $requestData): array
    {
        $curl = self::make_curl($requestData['uri']);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

        return self::execute($curl);
    }

    private static function make_curl(string $uri): \CurlHandle|bool
    {
        $curl = curl_init($uri);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/vnd.github.v3+json',
            'Authorization: token ' . $_ENV['USER_TOKEN'],
            'Content-Type: application/json',
            'User-Agent: Github-Api-Challenge'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return $curl;
    }

    private static function execute(\CurlHandle $curl): array
    {
        $response = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        if (curl_error($curl)){
            echo("CURL error!\n");
            echo(curl_error($curl));
            die("\nExit");
        }

        return ['code' => $responseCode, 'data' => json_decode($response, true)];
    }
}
