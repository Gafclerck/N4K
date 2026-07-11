<?php

namespace App\Config;

class Validator
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function setError(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    private function nonEmpty(array $data, string $key): void
    {
        if (empty(trim($data[$key] ?? ""))) {
            $this->setError($key, "Champ requis");
        }
    }

    private function validateEmail(array $data, string $key): void
    {
        $email = $data[$key] ?? "";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setError($key, "Email invalide");
        }
    }

    private function validateMinLength(array $data, string $key, int $minLength): void
    {
        $value = $data[$key] ?? "";
        if (strlen($value) < $minLength) {
            $this->setError($key, "Le champ doit contenir au moins $minLength caractères");
        }
    }

    private function validateMaxLength(array $data, string $key, int $maxLength): void
    {
        $value = $data[$key] ?? "";
        if (strlen($value) > $maxLength) {
            $this->setError($key, "Le champ doit contenir au plus $maxLength caractères");
        }
    }

    private function validateNumber(array $data, string $key): void
    {
        $value = $data[$key] ?? "";
        if (!is_numeric($value)) {
            $this->setError($key, "Le champ doit être un nombre");
        }
    }

    private function getRules(): array
    {
        return [
            "vide" => [$this, "nonEmpty"],
            "email" => [$this, "validateEmail"],
            "minLength" => [$this, "validateMinLength"],
            "maxLength" => [$this, "validateMaxLength"],
            "number" => [$this, "validateNumber"],
        ];
    }

    private function hasError(string $key): bool
    {
        return isset($this->errors[$key]);
    }

    private function ruleExists(string $ruleName): bool
    {
        return isset($this->getRules()[$ruleName]);
    }

    public function validate(array $inputRules, ?array $freshData = null): void
    {
        $this->errors = [];
        $freshData = $freshData ?? $_POST;
        if (!is_array($inputRules)) {
            throw new \InvalidArgumentException("Veullez forunir un tableau de règles valid");
        }
        if (!is_array($freshData)) {
            throw new \InvalidArgumentException("Veullez forunir des données sous forme de tableau");
        }
        $rules = $this->getRules();
        foreach ($inputRules as $key => $specs) {
            foreach ($specs as $ruleName) {
                if ($this->ruleExists($ruleName) && !$this->hasError($key)) {
                    $ruleCallback = $rules[$ruleName];
                    $ruleCallback($freshData, $key);
                }
            }
        }
    }

    public function noErrors(): bool
    {
        return count($this->errors) === 0;
    }

    public function getOldValues(array $data): array
    {
        return array_filter($data, function ($k) {
            return !isset($this->errors[$k]);
        });
    }
}
