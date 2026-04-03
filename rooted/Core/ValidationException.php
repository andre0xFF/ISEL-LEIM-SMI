<?php

namespace Core;

class ValidationException extends \Exception
{
    public readonly array $errors;
    public readonly array $old;

    public static function throw(array $errors, array $old): never
    {
        $instance = new static("The form failed to validate.");

        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
    }
}
