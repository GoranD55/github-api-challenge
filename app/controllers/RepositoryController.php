<?php

namespace App\Controllers;

use App\Enums\HttpMethodEnum;
use App\Http\Request;
use App\Http\Response;

class RepositoryController
{
    public static function index($request): string
    {
        if (!self::checkQuery($request)) {
            return (new Response([
                'code' => 400,
                'data' => ['message' => 'The username field is required. Set the username in query or in env']
            ]))->json();
        }

        $username = $request ?: $_ENV['USERNAME'];
        $requestData = [
            'uri' => $_ENV['USERS_REPOS_URL'] . "$username/repos"
        ];
        $response = Request::send(HttpMethodEnum::Get->value, $requestData);

        if ($response && $response['code'] === 404) {
            return (new Response([
                'code' => 404,
                'data' => ['message' => 'Repositories were not found for this user']
            ]))->json();
        }

        $formatted_response = ['username' => $username, 'repositories' => []];
        if ($response && property_exists((object)$response, "data")) {
            $repos = $response['data'];
            $formatted_response['repositories'] = array_map(function ($repo) {
                return (object)[
                    'full_name' => $repo['full_name'],
                    'url' => $repo['html_url']
                ];
            }, $repos);
        }

        return json_encode($formatted_response);
    }

    private static function checkQuery(string $query): bool
    {
        return ($query || isset($_ENV['USERNAME']));
    }
}