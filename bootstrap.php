<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

try {
    $dotenv->load();
} catch (Exception $exception) {
    die($exception);
}