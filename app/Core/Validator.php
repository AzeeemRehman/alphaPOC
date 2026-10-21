<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Minimal rule-based validator.
 * Rules: required, email, max:N, min:N, numeric, in:a,b,c, date, url, phone
 */
final class Validator
{
    public static function make(array $data, array $rules, array $labels = []): array
    {
        $errors = [];
        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? '';
            $value = is_string($value) ? trim($value) : $value;
            $label = $labels[$field] ?? ucfirst(str_replace('_', ' ', $field));

            foreach (explode('|', $ruleString) as $rule) {
                [$name, $arg] = array_pad(explode(':', $rule, 2), 2, null);

                if ($name !== 'required' && ($value === '' || $value === null)) {
                    continue; // optional and empty
                }

                $message = match ($name) {
                    'required' => ($value === '' || $value === null) ? "$label is required." : null,
                    'email'    => filter_var($value, FILTER_VALIDATE_EMAIL) ? null : 'Please enter a valid email address.',
                    'max'      => mb_strlen((string) $value) > (int) $arg ? "$label must be at most $arg characters." : null,
                    'min'      => mb_strlen((string) $value) < (int) $arg ? "$label must be at least $arg characters." : null,
                    'numeric'  => is_numeric($value) && $value >= 0 ? null : "$label must be a positive number.",
                    'in'       => in_array($value, explode(',', (string) $arg), true) ? null : "Please choose a valid $label.",
                    'date'     => strtotime((string) $value) !== false ? null : "$label must be a valid date.",
                    'url'      => filter_var($value, FILTER_VALIDATE_URL) ? null : "$label must be a valid URL.",
                    'phone'    => preg_match('/^[0-9+\-\s()]{7,20}$/', (string) $value) ? null : 'Please enter a valid phone number.',
                    default    => null,
                };

                if ($message !== null) {
                    $errors[$field] = $message;
                    break;
                }
            }
        }
        return $errors;
    }
}
