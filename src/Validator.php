<?php

namespace Maoshu\Engine;


class Validator
{
    /**
     * 验证参数是否满足要求
     *
     * @param array $params 参数数组
     * @param array $rules 验证规则
     * @return array 验证结果
     */
    public static function validate(array $params, array $rules)
    {
        $errors = [];
        
        foreach ($rules as $key => $rule) {
            $value = isset($params[$key]) ? $params[$key] : null;

            if (isset($rule['required']) && $rule['required'] && (is_null($value) || $value === '')) {
                $errors[] = "Parameter '$key' is required.";
                continue;
            }

            if (isset($rule['type']) && !self::validateType($value, $rule['type'])) {
                $errors[] = "Parameter '$key' must be of type {$rule['type']}.";
            }

            if (isset($rule['min']) && $value < $rule['min']) {
                $errors[] = "Parameter '$key' must be at least {$rule['min']}.";
            }

            if (isset($rule['max']) && $value > $rule['max']) {
                $errors[] = "Parameter '$key' must be at most {$rule['max']}.";
            }

            if (isset($rule['enum']) && !in_array($value, $rule['enum'])) {
                $errors[] = "Parameter '$key' must be one of " . implode(', ', $rule['enum']) . ".";
            }

            if (isset($rule['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Parameter '$key' must be a valid email address.";
            }
        }

        return $errors;
    }

    private static function validateType($value, $type)
    {
        switch ($type) {
            case 'integer':
                return filter_var($value, FILTER_VALIDATE_INT) !== false;
            case 'float':
                return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
            case 'string':
                return is_string($value);
            case 'boolean':
                return is_bool($value);
            default:
                return false;
        }
    }
}
