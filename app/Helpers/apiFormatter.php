<?php

namespace App\Helpers;

class ApiFormatter
{
    public static function filterSensitiveData(array $data = []): array
    {
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'api_key',
            'secret',
        ];

        foreach ($sensitiveFields as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = '[FILTERED]';
            }
        }

        return $data;
    }

    public static function createJson(
        int $statusCode,
        string $message,
        mixed $data = null
    ): array {
        if (is_array($data) && isset($data['user'])) {
            $data['user'] = self::filterSensitiveData($data['user']);
        }

        return [
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
        ];
    }

}
