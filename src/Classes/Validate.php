<?php

namespace Danupe\Plugin\User\Classes;

class Validate
{

    public static function validate(array $data, array $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $ruleParts = explode('|', $rule);

            foreach ($ruleParts as $rulePart) {
                if ($rulePart === 'required' && empty($data[$field])) {
                    $errors[$field][] = "$field is required.";
                } elseif (strpos($rulePart, 'min:') === 0) {
                    $min = (int) str_replace('min:', '', $rulePart);
                    if (strlen($data[$field] ?? '') < $min) {
                        $errors[$field][] = "$field must be at least $min characters.";
                    }
                } elseif (strpos($rulePart, 'max:') === 0) {
                    $max = (int) str_replace('max:', '', $rulePart);
                    if (strlen($data[$field] ?? '') > $max) {
                        $errors[$field][] = "$field must not exceed $max characters.";
                    }
                } elseif ($rulePart === 'email' && !filter_var($data[$field] ?? '', FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "$field must be a valid email address.";
                } elseif (strpos($rulePart, 'same:') === 0) {
                    $otherField = str_replace('same:', '', $rulePart);
                    if (($data[$field] ?? '') !== ($data[$otherField] ?? '')) {
                        $errors[$field][] = "$field must match $otherField.";
                    }
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION['old'] = $data;
            $_SESSION['validation_errors'] = $errors;
            return false;
        }

        $_SESSION['validation_errors'] = [];
        return true;
    }

    public static function getErrors()
    {
        return $_SESSION['validation_errors'] ?? [];
    }

    public static function isValid()
    {
        return empty($_SESSION['validation_errors']);
    }
}
