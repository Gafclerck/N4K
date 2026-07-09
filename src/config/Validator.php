<?php

namespace App\Config;

class Validator
{
    private static $errors = [];
    private function __construct() {}
    public static function getErrors()
    {
        return self::$errors;
    }

    private static function setError(string $key, string $message)
    {
        self::$errors[$key] = $message;
    }

    private static function nonEmpty(array $data, string $key)
    {
        if (empty(trim($data[$key] ?? ""))) {
            self::setError($key, "Champ requis");
        }
    }

    private static function validateEmail($data, string $key)
    {
        $email = $data[$key] ?? "";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::setError($key, "Email invalide");
        }
    }

    private static function validateMinLength($data, string $key, int $minLength)
    {
        $value = $data[$key] ?? "";
        if (strlen($value) < $minLength) {
            self::setError($key, "Le champ doit contenir au moins $minLength caractères");
        }
    }

    private static function validateMaxLength($data, string $key, int $maxLength)
    {
        $value = $data[$key] ?? "";
        if (strlen($value) > $maxLength) {
            self::setError($key, "Le champ doit contenir au plus $maxLength caractères");
        }
    }

    private static function validateNumber($data, string $key)
    {
        $value = $data[$key] ?? "";
        if (!is_numeric($value)) {
            self::setError($key, "Le champ doit être un nombre");
        }
    }
    // ============== LOGIC ==========================

    private static function getRules(): array
    {
        return [
            "vide" => [self::class, "nonEmpty"],
            "email" => [self::class, "validateEmail"],
            "minLength" => [self::class, "validateMinLength"],
            "maxLength" => [self::class, "validateMaxLength"],
            "number" => [self::class, "validateNumber"],
        ];
    }

    private static function hasError(string $key)
    {
        return isset(self::$errors[$key]);
    }

    private static function ruleExists(string $ruleName)
    {
        return isset(self::getRules()[$ruleName]);
    }

    public static function validate(array $inputRules, ?array $freshData = null)
    {
        self::$errors = [];
        $freshData = $freshData ?? $_POST;
        if (!is_array($inputRules)) {
            throw new \InvalidArgumentException("Input rules must be an array");
        }
        if (!is_array($freshData)) {
            throw new \InvalidArgumentException("Fresh data must be an array");
        }
        $rules = self::getRules();
        foreach ($inputRules as $key => $specs) {
            foreach ($specs as $ruleName) {
                if (self::ruleExists($ruleName) && !self::hasError($key)) {
                    $ruleCallback = $rules[$ruleName];
                    $ruleCallback($freshData, $key);
                }
            }
        }
    }

    public static function noErrors()
    {
        return count(self::$errors) == 0;
    }

    public static function getOldValues(array $data): array
    {
        return array_filter($data, function ($k) {
            return !isset(self::$errors[$k]);
        });
    }
}
