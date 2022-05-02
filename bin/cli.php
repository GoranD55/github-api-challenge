<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap.php';

use App\Commands\Repository as Repo;

$options = getopt(null, ['action:', 'name:']);

$action = $options['action'] ?? '';
$repoName = $options['name'] ?? '';

if (!$action) {
    die('Action is required.');
}
if (!$repoName) {
    die('Name is required.');
}

try {
    $result = Repo::$action($repoName);
} catch (Exception $exception) {
    die($exception);
}

echo("Result:\n");
var_dump($result);