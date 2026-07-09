<?php

namespace App\config;

use App\Entity\User;

class Session
{
    private function __construct() {}

    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function has(string $key)
    {
        return isset($_SESSION[$key]);
    }

    public static function destroy()
    {
        unset($_SESSION);
        session_destroy();
    }

    public static function isConnected()
    {
        return self::has("user");
    }

    public static function isAdmin()
    {
        return self::isConnected() && self::get("user")->getRole() == "Admin";
    }

    public static function getCurrentUser(): ?User
    {
        if (self::has("user")) {
            return $_SESSION["user"];
        }
        return null;
    }
}
