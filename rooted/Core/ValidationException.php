<?php

namespace Core;

class ValidationException extends \Exception
{
    public readonly array $errors;
    public readonly array $old;

    /**
     * Create and throw a validation exception.
     *
     * @param  array $errors  Field-specific error messages (e.g. ['email' => 'Invalid email']).
     * @param  array $old     The original form input, so fields can be re-populated.
     * @return never
     */
    public static function throw(array $errors, array $old): void
    {
        $instance = new static("The form failed to validate.");

        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
    }
}
