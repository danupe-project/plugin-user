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
                } elseif (strpos($rulePart, 'unique:') === 0) {
                    $uniqueParts = explode(',', str_replace('unique:', '', $rulePart));
                    $table = $uniqueParts[0] ?? null;
                    $id = $uniqueParts[2] ?? null;
                    if ($table && isset($data['id']) && $data['id'] == $id) {
                        continue;
                    }
                    if ($table && self::isDuplicate($table, $field, $data[$field] ?? '', $id)) {
                        $errors[$field][] = "$field must be unique.";
                    }
                }
            }
        }

        if (!empty($errors)) {
            danupe()->session()->set('old', $data);
            danupe()->session()->set('validation_errors', $errors);
            return false;
        }

        danupe()->session()->set('validation_errors', []);
        return true;
    }

    private static function isDuplicate(string $table, string $field, $value, $id = null)
    {
        $query = danupe()->plugin('database', 'database')->table($table)->where([$field, $value]);
        if ($id) {
            $query->where(['id', '!=', $id]);
        }
        
        return $query->exists();
    }

    public static function getErrors()
    {
        return danupe()->session()->get('validation_errors') ?? [];
    }

    public static function isValid()
    {
        return empty(danupe()->session()->get('validation_errors'));
    }
}
