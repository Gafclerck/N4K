<?php

namespace App\config;

final class Request
{
    private function __construct() {}
    public static function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public static function uri(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $path = '/' . trim((string)$path, '/');
        return $path === '//' ? '/' : $path;
    }

    public static function get(string|null $key = null, mixed $default = null): mixed
    {
        return $key ? $_GET[$key] ?? $default : $_GET;
    }

    public static function post(string| null $key = null, mixed $default = null): mixed
    {
        return $key ? $_POST[$key] ?? $default : $_POST;
    }

    public static function all(): array
    {
        return $_REQUEST;
    }

    public static function isGet(): bool
    {
        return self::method() === 'GET';
    }

    public static function isPost(): bool
    {
        return self::method() === 'POST';
    }
}
