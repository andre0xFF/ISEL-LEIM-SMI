<?php

namespace Core;

class Validator
{

    public const STRONG_PASSWORD_PATTERN = '^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).+$';

    public static function strongPassword($value): bool{

        return preg_match('/'.self::STRONG_PASSWORD_PATTERN. '/', $value) === 1;
    }


    public static function string($value, $min = 1, $max = INF)
    {
        $value = trim((string) $value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function email($value)
    {
        return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function greaterThan($value, $greaterThan)
    {
        return $value > $greaterThan;
    }

    public static function required($value)
    {
        return trim((string) $value) !== "";
    }

    public static function maxLength($value, $max)
    {
        return strlen(trim((string) $value)) <= $max;
    }

    public static function matches($value, $confirmation)
    {
        return $value === $confirmation;
    }
}
